<template>
  <card class="flex flex-col nova-detached-filters-card">
    <div class="px-3 py-4 detached-filters" :class="{ collapsed: isCollapsed }">
      <div class="flex flex-wrap" :class="getWidth(item)" v-for="item in card.filters" :key="item.key">
        <!-- Single Filter -->
        <nova-detached-filter
          v-if="isFilterComponent(item)"
          :width="'w-full'"
          :filter="item"
          :resource-name="resourceName"
          @handle-filter-changed="handleFilterChanged"
          @reset-filter="resetFilter"
        />

        <!-- Filter Column -->
        <nova-detached-filter
          v-else
          v-for="filter in item.filters"
          v-bind:key="filter.key"
          :width="getWidth(filter)"
          :filter="filter"
          :resource-name="resourceName"
          @handle-filter-changed="handleFilterChanged"
          @reset-filter="resetFilter"
        />
      </div>
    </div>
    <div class="detached-filters-buttons">
      <div class="detached-filters-button per-page-button" v-if="hasPerPageOptions">
        <select
          name="detached-per-page-select"
          slot="select"
          class="block w-full form-control-sm form-select"
          :value="currentPerPage"
          @change="perPageChanged($event)"
        >
          <option v-for="option in perPageOptions" :key="option">
            {{ option }}
          </option>
        </select>
      </div>
      <div class="detached-filters-button" v-if="card.withReset">
        <svg
          dusk="reset-detached-filters"
          class="reset-filter-btn"
          @click="clearAllFilters()"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 512.004 512.004"
          height="18"
          width="18"
        >
          <!-- RESET FILTERS ICON -->
          <path
            d="m361.183 0c-54.059 0-99.836 36.049-114.505 85.331h-192.948c-18.024 0-28.614 20.339-18.285 35.119.16.231-5.363-7.31 129.747 177.039 2.714 3.951 4.148 8.57 4.148 13.367v177.688c0 19.435 22.224 30.24 37.473 18.754l57.593-43.518c8.614-6.415 13.754-16.655 13.754-27.409v-125.515c0-4.798 1.435-9.417 4.149-13.369l46.497-63.451c76.139 21.439 151.81-36.022 151.81-114.791.001-65.752-53.577-119.245-119.433-119.245zm-103.192 279.919c-5.835 7.968-9.831 19.1-9.831 30.938 0 136.483.734 127.081-1.68 128.869-1.91 1.421 10.835-8.188-47.14 35.618v-164.488c0-11.012-3.327-21.608-9.622-30.646-.169-.242 4.923 6.71-120.835-164.88h172.938c-1.457 44.852 22.126 84.961 58.678 106.581zm103.192-71.428c-49.314 0-89.434-40.035-89.434-89.246 0-49.21 40.12-89.245 89.434-89.245 49.313 0 89.433 40.035 89.433 89.245.001 49.211-40.119 89.246-89.433 89.246z"
          />
          <path
            d="m400.201 80.298c-5.854-5.864-15.35-5.872-21.213-.02l-17.805 17.773-17.805-17.773c-5.863-5.853-15.361-5.846-21.213.02-5.853 5.862-5.844 15.36.019 21.213l17.767 17.735-17.767 17.735c-5.863 5.853-5.872 15.351-.019 21.213 5.833 5.844 15.331 5.891 21.213.02l17.805-17.773 17.805 17.773c5.845 5.834 15.343 5.862 21.213-.02 5.853-5.862 5.844-15.36-.019-21.213l-17.767-17.735 17.767-17.735c5.863-5.853 5.872-15.351.019-21.213z"
          />
        </svg>
      </div>
      <div class="detached-filters-button" v-if="card.persistFilters">
        <svg
          dusk="lock-detached-filters"
          class="lock-filters-btn"
          :class="{ active: isPersisting }"
          @click="toggleIsPersisting"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          width="16"
          height="16"
        >
          <!-- PERSIST FILTERS ICON -->
          <path
            d="m18.75 9h-.75v-3c0-3.309-2.691-6-6-6s-6 2.691-6 6v3h-.75c-1.24 0-2.25 1.009-2.25 2.25v10.5c0 1.241 1.01 2.25 2.25 2.25h13.5c1.24 0 2.25-1.009 2.25-2.25v-10.5c0-1.241-1.01-2.25-2.25-2.25zm-10.75-3c0-2.206 1.794-4 4-4s4 1.794 4 4v3h-8zm5 10.722v2.278c0 .552-.447 1-1 1s-1-.448-1-1v-2.278c-.595-.347-1-.985-1-1.722 0-1.103.897-2 2-2s2 .897 2 2c0 .737-.405 1.375-1 1.722z"
          />
        </svg>
      </div>
      <div class="detached-filters-button" v-if="card.withToggle">
        <svg
          dusk="collapse-detached-filters"
          class="toggle-filters-btn"
          :class="{ collapsed: isCollapsed }"
          @click="toggleIsCollapsed"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 511.641 511.641"
          width="20"
          height="16"
        >
          <!-- TOGGLE CARD ICON -->
          <path
            d="M148.32,255.76L386.08,18c4.053-4.267,3.947-10.987-0.213-15.04c-4.16-3.947-10.667-3.947-14.827,0L125.707,248.293    c-4.16,4.16-4.16,10.88,0,15.04L371.04,508.667c4.267,4.053,10.987,3.947,15.04-0.213c3.947-4.16,3.947-10.667,0-14.827    L148.32,255.76z"
          />
        </svg>
      </div>
    </div>
  </card>
</template>

<script>
import { Filterable, InteractsWithQueryString, PerPageable } from 'laravel-nova';

export default {
  mixins: [Filterable, InteractsWithQueryString, PerPageable],
  props: ['card', 'resourceName', 'viaResource', 'viaRelationship'],
  data: () => ({
    perPageStyle: null,
    persistedFilters: JSON.parse(localStorage.getItem('PERSISTED_DETACHED_FILTERS')),
    persistedResources: JSON.parse(localStorage.getItem('PERSIST_DETACHED_FILTERS')),
    collapsedResources: JSON.parse(localStorage.getItem('COLLAPSED_DETACHED_FILTERS')),

    isPersisting: this.card.isPersisting,
    isCollapsed: false,
  }),

  created() {
    this.initialiseIsPersisting();
    this.initialiseIsCollapsed();

    if (this.isPersisting) {
      if (this.persistedFilters && this.persistedFilters[this.resourceName]) this.loadPersistedFilters();
      else this.initializePersistedFilters();
    }
  },

  mounted() {
    if (!this.card.showPerPageInMenu) this.perPageDropdownStyle(true);
  },

  destroyed() {
    if (!this.card.showPerPageInMenu) this.perPageDropdownStyle(false);
  },

  methods: {
    getWidth(filter) {
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

    isFilterComponent(item) {
      return !!item.options && !!item.component;
    },

    toggleIsPersisting() {
      if (!this.persistedResources) this.persistedResources = {};
      if (this.persistedResources[this.resourceName]) this.persistedResources[this.resourceName] = [];

      this.persistedResources[this.resourceName] = !this.isPersisting;
      this.isPersisting = !this.isPersisting;

      localStorage.setItem('PERSIST_DETACHED_FILTERS', JSON.stringify(this.persistedResources));

      this.initializePersistedFilters();
      if (this.isPersisting) this.loadPersistedFromFilters();
    },

    toggleIsCollapsed() {
      if (!this.collapsedResources) this.collapsedResources = {};
      if (this.collapsedResources[this.resourceName]) this.collapsedResources[this.resourceName] = [];

      this.collapsedResources[this.resourceName] = !this.isCollapsed;
      this.isCollapsed = !this.isCollapsed;

      localStorage.setItem('COLLAPSED_DETACHED_FILTERS', JSON.stringify(this.collapsedResources));
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
      if (this.isPersisting) {
        // Get updated filter from $store;
        const updatedFilter = this.getFilter(filter.class);
        if (!updatedFilter) return;
        // Get filter index in localStorage;
        const filterIndex = this.persistedFilters[this.resourceName].findIndex(f => filter.class === f.filterClass);
        if (filterIndex == null || filterIndex < 0 || !this.persistedFilters[this.resourceName][filterIndex]) {
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

    getFilters() {
      return this.$store.getters[`${this.resourceName}/filters`];
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

    /**
     * Handle a filter state change.
     */
    filterChanged() {
      const encodedFilters = this.$store.getters[`${this.resourceName}/currentEncodedFilters`];

      if (this.$route.query[this.pageParameter] !== '1' || this.$route.query[this.filterParameter] !== encodedFilters)
        this.updateQueryString({
          [this.pageParameter]: 1,
          [this.filterParameter]: encodedFilters,
        });
    },

    /**
     * Update the desired amount of resources per page.
     */
    perPageChanged(event) {
      Nova.$emit('change-per-page', event.target.value);
    },

    /**
     * Load persisted filters from existing filters
     */
    loadPersistedFromFilters() {
      this.getFilters().forEach(filterItem => {
        this.persistedFilters[this.resourceName].push({
          filterClass: filterItem.class,
          value: filterItem.currentValue,
        });
      });

      localStorage.setItem('PERSISTED_DETACHED_FILTERS', JSON.stringify(this.persistedFilters));
    },

    /**
     * Remove or add dropdown per-page filter style tag to head
     */
    perPageDropdownStyle(addStyle) {
      const css = "div[dusk='filter-per-page'] { display: none !important }";
      const head = document.head || document.getElementsByTagName('head')[0];

      if (!this.perPageStyle) this.perPageStyle = document.createElement('style');
      addStyle ? head.appendChild(this.perPageStyle) : head.removeChild(this.perPageStyle);

      if (addStyle) this.perPageStyle.appendChild(document.createTextNode(css));
    },

    initialiseIsPersisting() {
      if (!this.persistedResources || !this.persistedResources[this.resourceName]) return (this.isPersisting = this.card.isPersisting);
      this.isPersisting = this.persistedResources[this.resourceName];
    },

    initialiseIsCollapsed() {
      if (!this.collapsedResources || !this.collapsedResources[this.resourceName]) return (this.isCollapsed = false);
      this.isCollapsed = this.collapsedResources[this.resourceName];
    },
  },

  computed: {
    pageParameter() {
      return this.viaRelationship ? this.viaRelationship + '_page' : this.resourceName + '_page';
    },

    /**
     * Resource card has per-page options
     */
    hasPerPageOptions() {
      return Array.isArray(this.perPageOptions);
    },

    /**
     * The per-page options configured for this resource.
     */
    perPageOptions() {
      return this.card.perPageOptions;
    },

    /**
     * Get the current per page value from the query string.
     */
    currentPerPage() {
      return this.$route.query[this.perPageParameter] || this.perPageOptions[0];
    },

    /**
     * Get the name of the per page query string variable.
     */
    perPageParameter() {
      return this.viaRelationship ? this.viaRelationship + '_per_page' : this.resourceName + '_per_page';
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
    max-height: 100vh;
    opacity: 1;
    z-index: 10;
    transition: all 0.5s $transition;
    will-change: max-height, transform, opacity, padding-top, padding-bottom;

    &.collapsed {
      opacity: 0;
      padding-top: 0.5rem;
      padding-bottom: 0.5rem;
      transform: translateY(-10%);
      max-height: 0;
      overflow: hidden;
      cursor: default;
    }
  }

  .detached-filter {
    height: auto;
    opacity: 1;

    > div:first-of-type {
      width: 100%;
    }

    h3 {
      background-color: transparent;
      text-transform: capitalize;
      padding: 0.25rem 4rem 0 0.5rem;
      font-size: 16px;
      font-weight: 300;
      font-family: Nunito, system-ui, BlinkMacSystemFont, -apple-system, sans-serif;

      white-space: nowrap;
      //overflow: hidden;
      text-overflow: ellipsis;
    }

    .reset-filter-btn {
      position: absolute;
      right: 0.4rem;
      top: 0.25rem;
    }
  }

  .detached-filters-buttons {
    position: absolute;
    display: flex;
    top: -2rem;
    right: 0;

    .detached-filters-button {
      padding: 0.5rem 0.6rem;
      background-color: var(--white);
      display: flex;
      align-items: center;

      svg {
        cursor: pointer;
      }

      &:last-of-type {
        border-top-right-radius: 0.25rem;
      }

      &:first-of-type {
        border-top-left-radius: 0.25rem;
      }

      &.per-page-button {
        padding: 0;

        select {
          border-radius: 0;
          border-color: transparent;

          &:focus {
            box-shadow: none;
          }
        }
      }
    }
  }

  .lock-filters-btn {
    opacity: 0.6;
    transition: all 0.3s $transition;

    &.active {
      fill: var(--success);
      opacity: 0.8;
    }

    &:hover {
      opacity: 1;
    }
  }

  .reset-filter-btn {
    opacity: 0.6;
    transition: opacity 0.3s $transition;
    cursor: pointer;

    &:hover {
      opacity: 1;
    }
  }

  .toggle-filters-btn {
    transform: rotate(90deg);
    transition: all 0.5s $transition;

    &.collapsed {
      transform: rotate(-90deg);
    }
  }
}
</style>
