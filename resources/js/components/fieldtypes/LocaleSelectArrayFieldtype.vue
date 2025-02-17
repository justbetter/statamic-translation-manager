<template>
    <div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('Locale') }}</th>
                    <th>{{ __('Value') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(locale, index) in locales" :key="index">
                    <td>
                        <p class="text-uppercase">{{ locale.label }}</p>
                    </td>
                    <td>
                        <text-input v-model="rows[locale.value]" :placeholder="__('Enter value')"
                            :name="'value-' + index" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        value: {
            type: Object,
            default: () => ({}),
        },
        config: {
            type: Object,
            default: () => ({}),
        },
    },
    data() {
        return {
            rows: this.parseInitialValue(this.value),
        };
    },
    watch: {
        rows: {
            handler() {
                this.$emit('input', this.transformToDatabaseFormat());
            },
            deep: true,
        },
    },
    methods: {
        parseInitialValue(value) {
            let rows = {};
            for (let index = 0; index < this.$attrs.meta.locales.length; index++) {
                const locale = this.$attrs.meta.locales[index];

                rows[locale] = value[locale] ?? '';
            }

            return rows;
        },
        transformToDatabaseFormat() {
            return this.rows;
        }
    },
    computed: {
        locales() {
            return Object.values(this.$attrs.meta.locales).map((option) => ({
                label: option,
                value: option,
            }));
        },
    },
};
</script>
