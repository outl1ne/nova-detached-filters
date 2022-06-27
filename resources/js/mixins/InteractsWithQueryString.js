import forEach from 'lodash/forEach';
import clone from 'lodash/cloneDeep';

let compiledSearchParams = null;

export default {
  methods: {
    /**
     * Update the given query string values.
     */
    updateQueryString(value) {
      let searchParams = new URLSearchParams(window.location.search);
      let page = clone(this.$page);

      forEach(value, (v, i) => {
        searchParams.set(i, v || '');
      });

      if (compiledSearchParams !== searchParams.toString()) {
        if (page.url !== `${window.location.pathname}?${searchParams}`) {
          page.url = `${window.location.pathname}?${searchParams}`;
          window.history.pushState(page, '', `${window.location.pathname}?${searchParams}`);
        }

        compiledSearchParams = searchParams.toString();
      }

      Nova.$emit('query-string-changed', searchParams);
    },
  },
};
