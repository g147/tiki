Object.defineProperty(exports, "__esModule", { value: true });
var utils_1 = require("@sentry/utils");
var global = utils_1.getGlobalObject();
var cachedFetchImpl;
/**
 * A special usecase for incorrectly wrapped Fetch APIs in conjunction with ad-blockers.
 * Whenever someone wraps the Fetch API and returns the wrong promise chain,
 * this chain becomes orphaned and there is no possible way to capture it's rejections
 * other than allowing it bubble up to this very handler. eg.
 *
 * const f = window.fetch;
 * window.fetch = function () {
 *   const p = f.apply(this, arguments);
 *
 *   p.then(function() {
 *     console.log('hi.');
 *   });
 *
 *   return p;
 * }
 *
 * `p.then(function () { ... })` is producing a completely separate promise chain,
 * however, what's returned is `p` - the result of original `fetch` call.
 *
 * This mean, that whenever we use the Fetch API to send our own requests, _and_
 * some ad-blocker blocks it, this orphaned chain will _always_ reject,
 * effectively causing another event to be captured.
 * This makes a whole process become an infinite loop, which we need to somehow
 * deal with, and break it in one way or another.
 *
 * To deal with this issue, we are making sure that we _always_ use the real
 * browser Fetch API, instead of relying on what `window.fetch` exposes.
 * The only downside to this would be missing our own requests as breadcrumbs,
 * but because we are already not doing this, it should be just fine.
 *
 * Possible failed fetch error messages per-browser:
 *
 * Chrome:  Failed to fetch
 * Edge:    Failed to Fetch
 * Firefox: NetworkError when attempting to fetch resource
 * Safari:  resource blocked by content blocker
 */
function getNativeFetchImplementation() {
    var _a, _b;
    if (cachedFetchImpl) {
        return cachedFetchImpl;
    }
    /* eslint-disable @typescript-eslint/unbound-method */
    // Fast path to avoid DOM I/O
    if (utils_1.isNativeFetch(global.fetch)) {
        return (cachedFetchImpl = global.fetch.bind(global));
    }
    var document = global.document;
    var fetchImpl = global.fetch;
    // eslint-disable-next-line deprecation/deprecation
    if (typeof ((_a = document) === null || _a === void 0 ? void 0 : _a.createElement) === "function") {
        try {
            var sandbox = document.createElement('iframe');
            sandbox.hidden = true;
            document.head.appendChild(sandbox);
            if ((_b = sandbox.contentWindow) === null || _b === void 0 ? void 0 : _b.fetch) {
                fetchImpl = sandbox.contentWindow.fetch;
            }
            document.head.removeChild(sandbox);
        }
        catch (e) {
            utils_1.logger.warn('Could not create sandbox iframe for pure fetch check, bailing to window.fetch: ', e);
        }
    }
    return (cachedFetchImpl = fetchImpl.bind(global));
    /* eslint-enable @typescript-eslint/unbound-method */
}
exports.getNativeFetchImplementation = getNativeFetchImplementation;
/**
 * Sends sdk client report using sendBeacon or fetch as a fallback if available
 *
 * @param url report endpoint
 * @param body report payload
 */
function sendReport(url, body) {
    var isRealNavigator = Object.prototype.toString.call(global && global.navigator) === '[object Navigator]';
    var hasSendBeacon = isRealNavigator && typeof global.navigator.sendBeacon === 'function';
    if (hasSendBeacon) {
        // Prevent illegal invocations - https://xgwang.me/posts/you-may-not-know-beacon/#it-may-throw-error%2C-be-sure-to-catch
        var sendBeacon = global.navigator.sendBeacon.bind(global.navigator);
        return sendBeacon(url, body);
    }
    if (utils_1.supportsFetch()) {
        var fetch_1 = getNativeFetchImplementation();
        return utils_1.forget(fetch_1(url, {
            body: body,
            method: 'POST',
            credentials: 'omit',
            keepalive: true,
        }));
    }
}
exports.sendReport = sendReport;
//# sourceMappingURL=utils.js.map