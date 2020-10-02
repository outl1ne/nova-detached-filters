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
          @input="handleFilterChanged(filter)"
          @change="handleFilterChanged(filter)"
        />

        <svg
          v-if="shouldShowResetFilterBtn(filter)"
          class="reset-filter-btn"
          @click="resetFilter(filter)"
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
    <div class="detached-filters-buttons">
      <div class="detached-filters-button">
        <svg
          class="reset-filter-btn"
          @click="clearAllFilters()"
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
      <div class="detached-filters-button" v-if="this.card.persistFilters">
        <svg
          class="lock-filters-btn"
          :class="{ active: shouldPersistFilters }"
          @click="toggleShouldPersistFilters"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          width="16"
          height="16"
        >
          <path
            d="m18.75 9h-.75v-3c0-3.309-2.691-6-6-6s-6 2.691-6 6v3h-.75c-1.24 0-2.25 1.009-2.25 2.25v10.5c0 1.241 1.01 2.25 2.25 2.25h13.5c1.24 0 2.25-1.009 2.25-2.25v-10.5c0-1.241-1.01-2.25-2.25-2.25zm-10.75-3c0-2.206 1.794-4 4-4s4 1.794 4 4v3h-8zm5 10.722v2.278c0 .552-.447 1-1 1s-1-.448-1-1v-2.278c-.595-.347-1-.985-1-1.722 0-1.103.897-2 2-2s2 .897 2 2c0 .737-.405 1.375-1 1.722z"
          />
        </svg>
      </div>
    </div>
  </card>
</template>

<script>
import { Filterable, InteractsWithQueryString } from 'laravel-nova';

export default {
  mixins: [Filterable, InteractsWithQueryString],
  props: ['card', 'resourceName', 'viaResource', 'viaRelationship'],
  data: () => ({
    persistedFilters: JSON.parse(localStorage.getItem('PERSISTED_DETACHED_FILTERS')),
    shouldPersistFilters: JSON.parse(localStorage.getItem('PERSIST_DETACHED_FILTERS')),
  }),

  mounted() {
    if (this.shouldPersistFilters) {
      if (this.persistedFilters && this.persistedFilters[this.resourceName]) this.loadPersistedFilters();
      else this.initializePersistedFilters();
    }
  },

  methods: {
    getFilterWidth(filter) {
      if (filter.width) return filter.width;
      return 'w-auto';
    },

    resetFilter(filter) {
      this.$store.commit(`${this.resourceName}/updateFilterState`, {
        filterClass: filter.class,
        value: null,
      });

      this.handleFilterChanged(filter);
    },

    shouldShowResetFilterBtn(filter) {
      return filter.withReset || this.card.withReset;
    },

    toggleShouldPersistFilters() {
      this.shouldPersistFilters = !this.shouldPersistFilters;
      localStorage.setItem('PERSIST_DETACHED_FILTERS', JSON.stringify(this.shouldPersistFilters));

      this.initializePersistedFilters();
    },

    loadPersistedFilters() {
      this.persistedFilters[this.resourceName].forEach(filterItem => {
        this.$store.commit(`${this.resourceName}/updateFilterState`, {
          filterClass: filterItem.filterClass,
          value: filterItem.value,
        });
      });

      this.filterChanged();
    },

    handleFilterChanged(filter) {
      if (this.shouldPersistFilters) {
        // Get updated filter from $store;
        const updatedFilter = this.getFilter(filter.class);
        if (!updatedFilter) return;

        // Get filter index in localStorage;
        const filterIndex = this.persistedFilters[this.resourceName].findIndex(filter => filter.key === filter.class);
        if (!filterIndex || filterIndex <= 0 || !this.persistedFilters[this.resourceName][filterIndex]) {
          // If key-value pair doesn't exist in localStorage, save new
          this.persistedFilters[this.resourceName].push({
            filterClass: filter.class,
            value: updatedFilter.currentValue,
          });
        } else {
          // If exists, update value
          this.persistedFilters[this.resourceName][filterIndex].value = updatedFilter.currentValue;
        }

        localStorage.setItem('PERSISTED_DETACHED_FILTERS', JSON.stringify(this.persistedFilters));
      }

      this.filterChanged();
    },

    getFilter(filterKey) {
      return this.$store.getters[`${this.resourceName}/getFilter`](filterKey);
    },

    initializePersistedFilters() {
      if (!this.persistedFilters) this.persistedFilters = {};
      this.persistedFilters[this.resourceName] = [];

      localStorage.setItem('PERSISTED_DETACHED_FILTERS', JSON.stringify(this.persistedFilters));
    },

    clearAllFilters() {
      this.initializePersistedFilters();
      this.clearSelectedFilters();
    },
  },

  computed: {
    pageParameter() {
      return this.viaRelationship ? this.viaRelationship + '_page' : this.resourceName + '_page';
    },
  },
};
</script>

<style lang="scss">
.nova-detached-filters-card {
  $transition: cubic-bezier(0.6, 0.4, 0.1, 0.9);
  height: auto;
  position: relative;

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
      cursor: pointer;
    }
  }

  .detached-filters-buttons {
    position: absolute;
    display: flex;
    top: -2rem;
    right: 0;

    .detached-filters-button {
      padding: 0.5rem 1rem;
      background-color: var(--white);
      border-color: var(grey);

      &:last-of-type {
        border-top-right-radius: 0.25rem;
      }

      &:first-of-type {
        border-top-left-radius: 0.25rem;
      }
    }
  }

  .lock-filters-btn {
    opacity: 0.6;
    transition: all 0.3s $transition;

    &.active {
      fill: #ff0000;
      opacity: 0.8;
    }

    &:hover {
      opacity: 1;
    }
  }

  .reset-filter-btn {
    opacity: 0.6;
    transition: all 0.3s $transition;

    &:hover {
      opacity: 1;
      transform: rotate(-120deg);
    }
  }
}
</style>
