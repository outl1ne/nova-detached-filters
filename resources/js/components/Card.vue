<template>
  <card class="flex flex-col">
    <div class="px-3 py-3 nova-detached-filters">
      <component
        v-for="filter in this.card.filters"
        :resource-name="resourceName"
        :key="filter.name"
        :filter-key="filter.class"
        :is="filter.component"
        :lens="''"
        @input="$emit('filter-changed')"
        @change="$emit('filter-changed')"
      />
    </div>
  </card>
</template>

<script>
  export default {
    props: [
      'card',
      'resourceName'

      // The following props are only available on resource detail cards...
      // 'resource',
      // 'resourceId',
      // 'resourceName',
    ],

    mounted() {
      console.log(this.card);
    },
  }
</script>
