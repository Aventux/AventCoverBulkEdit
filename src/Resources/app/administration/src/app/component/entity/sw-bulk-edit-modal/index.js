import template from './sw-bulk-edit-modal.html.twig';

const { Component, Mixin } = Shopware;

Component.override('sw-bulk-edit-modal', {
    template,

    inject: ['setCoverApiService'],

    mixins: [
        Mixin.getByName('notification'),
    ],

    methods: {
        setCover() {
            this.$emit('modal-close');

            if (this.itemCount > 0) {
                this.setCoverApiService.setCovers(Object.keys(this.bulkEditSelection)).then((response) => {
                    this.createNotificationSuccess({
                        title: this.$root.$tc('global.default.success'),
                        message: this.$tc('avent-bulk-edit-cover.success', 0, { count: this.itemCount }),
                    });

                    this.$router.push({ name: 'sw.product.index' });
                });

                return;
            }

            this.createNotificationError({
                title: this.$root.$tc('global.default.error'),
                message: this.$tc('avent-bulk-edit-cover.error'),
            });
        },
    }
});
