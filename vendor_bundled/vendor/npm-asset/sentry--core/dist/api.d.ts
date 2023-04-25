import { DsnLike, SdkMetadata } from '@sentry/types';
import { Dsn } from '@sentry/utils';
/**
 * Helper class to provide urls, headers and metadata that can be used to form
 * different types of requests to Sentry endpoints.
 * Supports both envelopes and regular event requests.
 **/
export declare class API {
    /** The DSN as passed to Sentry.init() */
    dsn: DsnLike;
    /** Metadata about the SDK (name, version, etc) for inclusion in envelope headers */
    metadata: SdkMetadata;
    /** The internally used Dsn object. */
    private readonly _dsnObject;
    /** The envelope tunnel to use. */
    private readonly _tunnel?;
    /** Create a new instance of API */
    constructor(dsn: DsnLike, metadata?: SdkMetadata, tunnel?: string);
    /** Returns the Dsn object. */
    getDsn(): Dsn;
    /** Does this transport force envelopes? */
    forceEnvelope(): boolean;
    /** Returns the prefix to construct Sentry ingestion API endpoints. */
    getBaseApiEndpoint(): string;
    /** Returns the store endpoint URL. */
    getStoreEndpoint(): string;
    /**
     * Returns the store endpoint URL with auth in the query string.
     *
     * Sending auth as part of the query string and not as custom HTTP headers avoids CORS preflight requests.
     */
    getStoreEndpointWithUrlEncodedAuth(): string;
    /**
     * Returns the envelope endpoint URL with auth in the query string.
     *
     * Sending auth as part of the query string and not as custom HTTP headers avoids CORS preflight requests.
     */
    getEnvelopeEndpointWithUrlEncodedAuth(): string;
    /** Returns only the path component for the store endpoint. */
    getStoreEndpointPath(): string;
    /**
     * Returns an object that can be used in request headers.
     * This is needed for node and the old /store endpoint in sentry
     */
    getRequestHeaders(clientName: string, clientVersion: string): {
        [key: string]: string;
    };
    /** Returns the url to the report dialog endpoint. */
    getReportDialogEndpoint(dialogOptions?: {
        [key: string]: any;
        user?: {
            name?: string;
            email?: string;
        };
    }): string;
    /** Returns the envelope endpoint URL. */
    private _getEnvelopeEndpoint;
    /** Returns the ingest API endpoint for target. */
    private _getIngestEndpoint;
    /** Returns a URL-encoded string with auth config suitable for a query string. */
    private _encodedAuth;
}
//# sourceMappingURL=api.d.ts.map