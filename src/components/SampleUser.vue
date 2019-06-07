<template>
  <panel name="Create test record" icon="fas fa-book-reader" class="panel-success">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Name</label>

      <div class="col-sm-10">
        <input type="text" class="form-control" v-model="form.name">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Help text</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" v-model="form.help">
        <span
          class="form-text m-b-none"
        >A block of help text that breaks onto a new line and may extend beyond one line.</span>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-lg-2 col-form-label">Disabled</label>

      <div class="col-lg-10">
        <input type="text" disabled placeholder="Disabled input here..." class="form-control">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Column sizing</label>

      <div class="col-sm-10">
        <div class="row">
          <div class="col-md-2">
            <input type="text" placeholder=".col-md-2" class="form-control" v-model="col1">
          </div>
          <div class="col-md-3">
            <input type="text" placeholder=".col-md-3" class="form-control" v-model="col2">
          </div>
          <div class="col-md-4">
            <input type="text" placeholder=".col-md-4" class="form-control" v-model="col3">
          </div>
        </div>
      </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Status</label>
      <div class="col-sm-10">
        <select class="form-control m-b" name="status" v-model="status">
          <option value="ACTIVE">ACTIVE</option>
          <option value="COMPLETED">COMPLETED</option>
        </select>
      </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group row">
      <div class="col-sm-4 col-sm-offset-2">
        <button class="btn btn-white btn-sm" type="submit" @click="cancelProcess()">Cancel</button>
        <button
          class="btn btn-primary btn-sm"
          type="submit"
          @click="completeTask({form,status})"
        >Save changes</button>
      </div>
    </div>
  </panel>
</template>

<script>
export default {
  path: "/sample/test",
  mixins: [window.workflowMixin],
  data() {
    return {
      form: {
        name: "",
        help: "",
        col1: "",
        col2: "",
        col3: ""
      },
      status: "ACTIVE",
    };
  }
};
</script>
