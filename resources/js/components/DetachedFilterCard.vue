<template>
  <card class="flex flex-col h-auto relative o1-min-h-0">
    <div
      v-if="hasAnyActions"
      class="o1-flex o1-justify-end overflow-hidden"
      :class="{
        'rounded-lg': isCollapsed,
        'o1-rounded-t-lg  border-b border-gray-200 dark:border-gray-600': !isCollapsed,
      }"
    >
      <ActionButton v-if="card.withReset" @click="clearAllFilters()">
        <ResetIcon />
      </ActionButton>

      <ActionButton @click="toggleIsPersisting" v-if="card.persistFilters">
        <LockIcon
          :class="{
            'text-green-500 opacity-100': isPersisting,
            'text-gray-400 opacity-80 hover:opacity-100': !isPersisting,
          }"
        />
      </ActionButton>

      <ActionButton v-if="card.withToggle" @click="toggleIsCollapsed">
        <CollapseIcon :class="{ 'o1-rotate-90': isCollapsed, 'o1-rotate-[270deg]': !isCollapsed }" />
      </ActionButton>
    </div>
    <div class="px-3 py-4 flex flex-wrap max-h-screen opacity-100 z-10" :class="{ hidden: isCollapsed }">
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
  </card>
</template>

<script>
import { Filterable, RouteParameters, PerPageable, InteractsWithQueryString } from '../mixins';
import ActionButton from './ActionButton';
import { LockIcon, ResetIcon, CollapseIcon } from './icons';

export default {
  mixins: [Filterable, InteractsWithQueryString, PerPageable, RouteParameters],
  components: { ActionButton, LockIcon, ResetIcon, CollapseIcon },
  props: ['card', 'resourceName', 'viaResource', 'viaRelationship'],

  data: () => ({
    perPageStyle: null,
    persistedFilters: JSON.parse(localStorage.getItem('PERSISTED_DETACHED_FILTERS')),
    persistedResources: JSON.parse(localStorage.getItem('PERSIST_DETACHED_FILTERS')),
    collapsedResources: JSON.parse(localStorage.getItem('COLLAPSED_DETACHED_FILTERS')),

    isPersisting: false,
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
      if (!this.persistedResources || !this.persistedResources[this.resourceName])
        return (this.isPersisting = this.card.persistFiltersDefault);
      this.isPersisting = this.persistedResources[this.resourceName];
    },

    initialiseIsCollapsed() {
      if (!this.collapsedResources || !this.collapsedResources[this.resourceName]) return (this.isCollapsed = false);
      this.isCollapsed = this.collapsedResources[this.resourceName];
    },
  },

  computed: {
    hasAnyActions() {
      return this.card.withReset || this.card.withToggle || this.card.persistFilters;
    },
  },
};
</script>
