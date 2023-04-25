import { Event, Integration } from '@sentry/types';
/** JSDoc */
interface BreadcrumbsOptions {
    console: boolean;
    dom: boolean | {
        serializeAttribute: string | string[];
    };
    fetch: boolean;
    history: boolean;
    sentry: boolean;
    xhr: boolean;
}
/**
 * Default Breadcrumbs instrumentations
 * TODO: Deprecated - with v6, this will be renamed to `Instrument`
 */
export declare class Breadcrumbs implements Integration {
    /**
     * @inheritDoc
     */
    static id: string;
    /**
     * @inheritDoc
     */
    name: string;
    /** JSDoc */
    private readonly _options;
    /**
     * @inheritDoc
     */
    constructor(options?: Partial<BreadcrumbsOptions>);
    /**
     * Create a breadcrumb of `sentry` from the events themselves
     */
    addSentryBreadcrumb(event: Event): void;
    /**
     * Instrument browser built-ins w/ breadcrumb capturing
     *  - Console API
     *  - DOM API (click/typing)
     *  - XMLHttpRequest API
     *  - Fetch API
     *  - History API
     */
    setupOnce(): void;
    /**
     * Creates breadcrumbs from console API calls
     */
    private _consoleBreadcrumb;
    /**
     * Creates breadcrumbs from DOM API calls
     */
    private _domBreadcrumb;
    /**
     * Creates breadcrumbs from XHR API calls
     */
    private _xhrBreadcrumb;
    /**
     * Creates breadcrumbs from fetch API calls
     */
    private _fetchBreadcrumb;
    /**
     * Creates breadcrumbs from history API calls
     */
    private _historyBreadcrumb;
}
export {};
//# sourceMappingURL=breadcrumbs.d.ts.map