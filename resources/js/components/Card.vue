<template>
  <card class="flex flex-col nova-detached-filters-card">
    <div class="px-3 py-4 detached-filters">
      <div class="relative flex detached-filter" :class="getFilterWidth(filter)" v-for="filter in this.card.filters">
        <component
          :resource-name="resourceName"
          :key="filter.name"
          :filter-key="filter.class"
          :is="filter.component"
          :lens="''"
          @input="$emit('filter-changed')"
          @change="$emit('filter-changed')"
        />

        <svg
          v-if="shouldShowResetFilterBtn(filter)"
          class="reset-filter-btn"
          @click="handleFilterChange(filter)"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 460.801 460.801"
          height="16"
          width="16"
        >
          <path
            d="M231.298,17.068c-57.746-0.156-113.278,22.209-154.797,62.343V17.067C76.501,7.641,68.86,0,59.434,0    S42.368,7.641,42.368,17.067v102.4c-0.002,7.349,4.701,13.874,11.674,16.196l102.4,34.133c8.954,2.979,18.628-1.866,21.606-10.82    c2.979-8.954-1.866-18.628-10.82-21.606l-75.605-25.156c69.841-76.055,188.114-81.093,264.169-11.252    s81.093,188.114,11.252,264.169s-188.114,81.093-264.169,11.252c-46.628-42.818-68.422-106.323-57.912-168.75    c1.653-9.28-4.529-18.142-13.808-19.796s-18.142,4.529-19.796,13.808c-0.018,0.101-0.035,0.203-0.051,0.304    c-2.043,12.222-3.071,24.592-3.072,36.983C8.375,361.408,107.626,460.659,230.101,460.8    c122.533,0.331,222.134-98.734,222.465-221.267C452.896,117,353.832,17.399,231.298,17.068z"
          />
        </svg>
      </div>
    </div>
  </card>
</template>

<script>
export default {
  props: ['card', 'resourceName'],

  methods: {
    getFilterWidth(filter) {
      if (filter.width) return filter.width;
      return 'w-auto';
    },

    handleFilterChange(filter) {
      this.$store.commit(`${this.resourceName}/updateFilterState`, {
        filterClass: filter.class,
        value: null,
      });
    },

    shouldShowResetFilterBtn(filter) {
      return filter.withReset || this.card.withReset;
    },
  },
};
</script>

<style lang="scss">
.nova-detached-filters-card {
  $transition: cubic-bezier(0.6, 0.4, 0.1, 0.9);
  height: auto;

  .detached-filters {
    display: flex;
    flex-wrap: wrap;
  }

  .detached-filter {
    > div:first-of-type {
      width: 100%;
    }

    h3 {
      background-color: transparent;
      text-transform: capitalize;
      color: var(--black);
      padding: 0.25rem 4rem 0 0.5rem;
      font-size: 16px;
      font-weight: 300;
      font-family: Nunito, system-ui, BlinkMacSystemFont, -apple-system, sans-serif;

      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .reset-filter-btn {
      position: absolute;
      right: 0.75rem;
      top: 0.25rem;
      opacity: 0.4;
      cursor: pointer;
      transition: all 0.3s $transition;

      &:hover {
        opacity: 1;
        transform: rotate(-120deg);
      }
    }
  }
}
</style>
