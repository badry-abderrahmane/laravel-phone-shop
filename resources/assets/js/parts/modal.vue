<template lang="html">
  <div class="modal fade" v-bind:id="id" style="display: none;">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span></button>
                      <slot name="title"></slot>
              </div>
              <div class="modal-body">
                  <slot name="body"></slot>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
export default {
  props:["id"]
}
</script>

<style lang="css">
</style>
