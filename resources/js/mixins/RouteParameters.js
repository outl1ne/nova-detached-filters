export default {
  data() {
    const searchParams = new URLSearchParams(window.location.search);

    return {
      route: {
        params: Object.fromEntries(searchParams.entries()),
      },
    };
  },

  async created() {
    Nova.$on('query-string-changed', this.listenToQueryStringChanges);
  },

  beforeUnmount() {
    Nova.$off('query-string-changed', this.listenToQueryStringChanges);
  },

  methods: {
    listenToQueryStringChanges(searchParams) {
      this.route.params = Object.fromEntries(searchParams.entries());
    },
  },
};
