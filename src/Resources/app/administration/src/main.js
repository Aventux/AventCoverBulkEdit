import SetCoverApiService from './service/set-cover.api.service';
import './app/component/entity/sw-bulk-edit-modal';

const {Application} = Shopware;

Application.addServiceProvider('setCoverApiService', (container) => {
    const initContainer = Application.getContainer('init');

    return new SetCoverApiService(initContainer.httpClient, container.loginService);
});
