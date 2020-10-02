import DetachedFilterCard from './components/Card';

Nova.booting((Vue, router, store) => {
  Vue.component('nova-detached-filters', DetachedFilterCard);
});
