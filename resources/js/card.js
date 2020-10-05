import DetachedFilterCard from './components/Card';
import DetachedFilter from './components/DetachedFilter';

Nova.booting((Vue, router, store) => {
  Vue.component('nova-detached-filters', DetachedFilterCard);
  Vue.component('nova-detached-filter', DetachedFilter);
});
