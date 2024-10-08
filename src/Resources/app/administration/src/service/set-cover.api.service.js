const ApiService = Shopware.Classes.ApiService;

class SetCoverApiService extends ApiService {
    constructor(httpClient, loginService, apiEndpoint = 'avent-set-cover') {
        super(httpClient, loginService, apiEndpoint);
    }

    async setCovers(productIds) {
        const headers = this.getBasicHeaders();

        return await this.httpClient
            .post(
                `_action/${this.getApiBasePath()}`,
                {
                    productIds: productIds,
                },
                {
                    headers: headers,
                }
            )
            .then((response) => {
                return ApiService.handleResponse(response);
            });
    }
}

export default SetCoverApiService;
