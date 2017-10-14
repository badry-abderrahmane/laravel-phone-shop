export class Errors {

      /**
      // Constructor
      //
      **/
      constructor(){
        this.errors = {};
      }

      /**
      // Check if the given field has value
      // @param: field
      **/
      has(field){
        return this.errors.hasOwnProperty(field);
      }

      /**
      // Check if there is any value in errors
      //
      **/
      any(){
        return Object.keys(this.errors).length > 0;
      }

      /**
      // Get field value by name
      // @param: field
      **/
      get(field){
        if (this.errors[field]) {
          return this.errors[field][0];
        }
      }

      /**
      // Save given error to errors object
      // @param: field
      **/
      record(errors){
        this.errors = errors;
      }

      /**
      // Delete all errors
      // @param: field
      **/
      clear(field){
        if (field){
          delete this.errors[field];
          return;
        }
        this.errors = {};
      }

}
