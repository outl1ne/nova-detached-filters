import { mapActions, mapGetters } from 'vuex';

export default {
  methods: mapActions(['syncQueryString', 'updateQueryString']),
  computed: mapGetters(['queryStringParams']),
};
