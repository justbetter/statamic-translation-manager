import LocaleSelectArrayFieldtype from "./components/fieldtypes/LocaleSelectArrayFieldtype.vue";
import LocaleSelectArrayIndexFieldtype from "./components/fieldtypes/LocaleSelectArrayIndexFieldtype.vue";
Statamic.booting(() => {
    Statamic.$components.register('locale_select_array-fieldtype', LocaleSelectArrayFieldtype);
    Statamic.$components.register('locale_select_array-fieldtype-index', LocaleSelectArrayIndexFieldtype);
});
