import DetachedFilterCard from './components/DetachedFilterCard';
import DetachedFilter from './components/DetachedFilter';
import AttachedHiddenFilter from './components/AttachedHiddenFilter';

Nova.booting(Vue => {
  Vue.component('nova-detached-filters-card', DetachedFilterCard);
  Vue.component('nova-detached-filter', DetachedFilter);
  Vue.component('nova-attached-hidden-filter', AttachedHiddenFilter);
});
