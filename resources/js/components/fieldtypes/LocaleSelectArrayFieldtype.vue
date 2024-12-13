<template>
    <div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Locale</th>
                    <th>Value</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in rows" :key="index">
                    <td>
                        <v-select 
                            v-model="row.key" 
                            :options="configOptions" 
                            label="label" 
                            value-field="value"
                            placeholder="Select a key" 
                        />
                    </td>
                    <td>
                        <text-input v-model="row.value" placeholder="Enter value" :name="'value-' + index" />
                    </td>
                    <td>
                        <button type="button" @click="removeRow(index)">Remove</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn-primary" @click="addRow">Add Row</button>
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
    computed: {
        configOptions() {
            return Object.values(this.$attrs.meta.options).map((option) => ({
                label: option,
                value: option,
            }));
        },
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
            return Object.entries(value).map(([key, val]) => ({
                key: { label: key, value: key },
                value: val,
            }));
        },
        transformToDatabaseFormat() {
            return this.rows.reduce((acc, row) => {
                if (row.key && row.key.value) {
                    acc[row.key.value] = row.value;
                }
                return acc;
            }, {});
        },
        addRow() {
            this.rows.push({ key: { label: '', value: '' }, value: '' });
        },
        removeRow(index) {
            this.rows.splice(index, 1);
        },
    },
};
</script>

