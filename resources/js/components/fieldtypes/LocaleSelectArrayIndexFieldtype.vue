<template>
    <span v-if="parsedKeys.length">
        {{ parsedKeys.join(', ') }}
    </span>
    <span v-else>
        <em>No keys</em>
    </span>
</template>

<script>
export default {
    props: {
        value: {
            type: [Object, Array],
            default: () => ({}),
        },
    },
    computed: {
        parsedKeys() {
            console.log(this.value)
            if (Array.isArray(this.value)) {
                return this.value.map((item) => item.key?.value || item.key);
            } else if (typeof this.value === 'object') {
                return Object.keys(this.value);
            }
            return [];
        },
    },
};
</script>
