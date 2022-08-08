<template>
  <div class="relative flex h-auto opacity-100 nova-detached-filter" :class="width">
    <component
      :resource-name="resourceName"
      :key="filter.name"
      :filter-key="filter.class"
      :is="filter.component"
      :lens="''"
      class="py-2"
      @input="$emit('handle-filter-changed', filter)"
      @change="$emit('handle-filter-changed', filter)"
    />

    <div class="absolute o1-right-3 o1-top-1 flex">
      <ActionButton class="p-1" @click="$emit('reset-filter', filter)" v-if="filter.withReset">
        <ResetIcon />
      </ActionButton>
    </div>
  </div>
</template>

<script>
import ActionButton from './ActionButton';
import { ResetIcon } from './icons';

export default {
  components: { ActionButton, ResetIcon },
  props: ['filter', 'width', 'resourceName'],
};
</script>

<style lang="scss">
.nova-detached-filter {
  h3 {
    margin-bottom: 2px;

    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
  }

  h3 + div {
    padding-top: 0.1rem;
    padding-bottom: 0.1rem;
  }

  > div:first-of-type {
    width: 100%;
  }
}
</style>
