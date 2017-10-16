<template>
  <div>
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li v-bind:class="{ active: key == 0 }" v-for="(options,optiongroup,key) in managedOptions">
            <a data-toggle="tab" aria-expanded="true" v-bind:href="'#'+optiongroup">{{ optiongroup }}</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane" v-bind:id="optiongroup" v-bind:class="{ active: key == 0 }" v-for="(options,optiongroup,key) in managedOptions">
            <table class="table">
              
              <tbody>
                <tr v-for="(value,option,key) in options">
                  <td><b>{{ option }}</b></td>
                  <td>{{ value }}</td>
                  <td>
                    <button class="btn" @click="editProduct(product)"><i class="fa fa-icon fa-edit"></i></button>
                    <button class="btn" @click="destroyProduct(product)"><i class="fa fa-icon fa-trash"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
  export default{
    props: ['productoptions'],

    data(){
      return{
        options : JSON.parse(this.productoptions)
      }
    },
    computed: {
      // a computed getter
      managedOptions: function () {
        let optionLabels = {};
        this.options.map(function(value,key){
          console.log(value.option.optiongroup.name);
          optionLabels[value.option.optiongroup.name] = {};
        });
        this.options.map(function(value,key){
          optionLabels[value.option.optiongroup.name][value.option.name]= value.value
        });
        return optionLabels;
      }
    }

  }


</script>
