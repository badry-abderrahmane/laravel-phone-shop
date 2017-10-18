<template>
 <div class="modal modal-danger fade in" id="modal-confirm-danger" style="display: block; padding-right: 17px;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">{{ title }}</h4>
        </div>
        <div class="modal-body">
          <p>{{ Message }}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline pull-left" @click="cancel">Close</button>
          <button type="button" class="btn btn-outline" @click="$close(true)">Confirm</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</template>

<script>
 export default {
   data(){
     return {
       confirm: {}
     }
   }
   created(){
     Event.$on('confirm-danger', (confirm) => {
         this.confirm = confirm;
     });
   },
   methods: {
     cancel(){
        $('#modal-confirm-danger').modal('hide');
        console.log('canceled');
     },
     confirm(){
       console.log('confirmed');
       $('#modal-confirm-danger').modal('hide');
     }
   }
 }
</script>
