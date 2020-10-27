import DetachedFilterCard from './components/Card';
import DetachedFilter from './components/DetachedFilter';
import FilterMenu from './components/FilterMenu';

Nova.booting((Vue, router, store) => {
  Vue.component('nova-detached-filters', DetachedFilterCard);
  Vue.component('nova-detached-filter', DetachedFilter);
  Vue.component('filter-menu', FilterMenu);
});
