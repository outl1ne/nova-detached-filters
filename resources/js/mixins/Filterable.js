export default {
  data: () => ({
    filterIsActive: false,
  }),

  methods: {
    /**
     * Clear filters and reset the resource table
     */
    async clearSelectedFilters(lens) {
      if (lens) {
        await this.$store.dispatch(`${this.resourceName}/resetFilterState`, {
          resourceName: this.resourceName,
          lens,
        });
      } else {
        await this.$store.dispatch(`${this.resourceName}/resetFilterState`, {
          resourceName: this.resourceName,
        });
      }

      this.updateQueryString({
        [this.pageParameter]: 1,
        [this.filterParameter]: '',
      });

      Nova.$emit('filter-reset');
      Nova.$emit('filter-changed', ['']);
    },

    /**
     * Handle a filter state change.
     */
    filterChanged() {
      const encodedFilters = this.$store.getters[`${this.resourceName}/currentEncodedFilters`];

      if (this.route.params[this.pageParameter] !== '1' || this.route.params[this.filterParameter] !== encodedFilters) {
        this.updateQueryString({
          [this.pageParameter]: 1,
          [this.filterParameter]: encodedFilters,
        });
      }

      Nova.$emit('filter-changed', [encodedFilters]);
    },
  },

  computed: {
    /**
     * Get the name of the filter query string variable.
     */
    filterParameter() {
      return this.resourceName + '_filter';
    },
  },
};
