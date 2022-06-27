export default {
  data: () => ({ perPage: 25 }),

  methods: {
    /**
     * Sync the per page values from the query string.
     */
    initializePerPageFromQueryString() {
      this.perPage = this.currentPerPage;
    },

    /**
     * Update the desired amount of resources per page.
     */
    perPageChanged(perPage) {
      Nova.$emit('change-per-page', perPage);
    },
  },

  computed: {
    /**
     * Resource card has per-page options
     */
    hasPerPageOptions() {
      return Array.isArray(this.perPageOptions);
    },

    /**
     * Get the current per page value from the query string.
     */
    currentPerPage() {
      return this.route.params[this.perPageParameter] || 25;
    },

    /**
     * The per-page options configured for this resource.
     */
    perPageOptions() {
      return this.card.perPageOptions;
    },

    /**
     * Get the name of the per page query string variable.
     */
    pageParameter() {
      return this.viaRelationship ? this.viaRelationship + '_page' : this.resourceName + '_page';
    },

    /**
     * Get the name of the per page query string variable.
     */
    perPageParameter() {
      return this.viaRelationship ? this.viaRelationship + '_per_page' : this.resourceName + '_per_page';
    },
  },
};
