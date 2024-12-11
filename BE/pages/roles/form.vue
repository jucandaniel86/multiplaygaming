<template>
  <SharedCardHeader :title="title">
    <template v-slot:content>
      <v-progress-linear
        v-if="isLoading"
        color="primary"
        height="10"
        indeterminate
      ></v-progress-linear>
      <div class="pa-3" v-else>
        <v-text-field
          v-model="form.name"
          :disabled="id === 'edit'"
          label="Name"
        />

        <v-row>
          <v-col
            cols="3"
            class="mb-2"
            v-for="(parent, i) in role_permissions"
            :key="`permission${i}`"
          >
            <div
              style="border-bottom: 1px solid #ccc; background: #fff"
              class="d-flex justify-start ga-2 align-center pb-2"
            >
              <v-checkbox
                class="pa-0 ma-0"
                color="blue"
                hide-details
                :true-value="1"
                :false-value="0"
                :input-value="isChecked(parent)"
                @change="(e) => checkPermisions(e, parent)"
              />
              <h5 class="pa-0 ma-0">{{ `${i} (${parent.length})` }}</h5>
            </div>
            <v-simple-table fixed-header height="200">
              <thead>
                <th></th>
              </thead>
              <tbody>
                <tr v-for="p in parent" :key="`Permission_${i}_${p.id}`">
                  <v-checkbox
                    v-model="permissions"
                    :label="p.name"
                    :id="`_permission${p.id}`"
                    :value="p.id"
                    class="h-4 w-4"
                  />
                </tr>
              </tbody>
            </v-simple-table>
          </v-col>
        </v-row>
      </div>
    </template>
    <template v-slot:footer>
      <div class="d-flex gap-2 justify-center pa-3">
        <v-btn color="primary" @click.prevent="save" :disabled="isLoading">
          <i
            class="fa"
            :class="{
              'fa fa-save': !isLoadingSave,
              'fa fa-spinner fa-spin': isLoadingSave,
            }"
          />
          Save
        </v-btn>
        <v-btn class="ml-2" @click.prevent="closeForm">
          <span>Cancel</span>
        </v-btn>
      </div>
    </template>
  </SharedCardHeader>
</template>
<script>
var _ = require("lodash");

export default {
  props: {
    role: {
      required: false,
      type: Object,
      default: () => {},
    },
    id: {
      type: Number,
      required: false,
      default: 0,
    },
  },
  data() {
    return {
      permissions: [],
      role_permissions: [],
      isLoading: false,
      isLoadingSave: false,
      title: "Save Role",
      form: {
        name: "",
      },
    };
  },
  async created() {
    await this.getPermissions();
    if (this.id) {
      await this.getRole();
    }
  },
  methods: {
    checkPermisions(isChecked, permissions) {
      [...permissions.map((el) => el.id)].forEach((el) => {
        let _i = this.permissions.indexOf(el);
        if (_i !== -1) {
          this.permissions.splice(_i, 1);
        }
      });
      if (isChecked) {
        this.permissions = [
          ...this.permissions,
          ...permissions.map((el) => el.id),
        ];
      }
    },

    isChecked(permissions) {
      let _total = permissions.length;
      let i = 0;
      [...permissions.map((el) => el.id)].forEach((el) => {
        let _i = this.permissions.indexOf(el);
        if (_i !== -1) {
          i++;
        }
      });
      return _total === i ? 1 : 0;
    },

    formatPermissions(data) {
      return _.mapValues(_.groupBy(data, "category_name"), (clist) =>
        clist.map((item) => _.omit(item, "makcategorye"))
      );
    },

    async getPermissions() {
      this.isLoading = true;
      try {
        const { data } = await this.$axios.get("/permissions/all");

        this.role_permissions = this.formatPermissions(data.data);

        this.isLoading = false;
      } catch (err) {
        this.isLoading = false;
      }
    },
    async getRole() {
      try {
        const { data } = await this.$axios.get("/roles/get", {
          params: {
            id: this.id,
          },
        });
        this.form = {
          ...this.form,
          ...data.data,
        };
        if (data.data && data.data.permissions) {
          this.permissions = data.data.permissions.map((e) => e.id);

          this.$forceUpdate();
        }
      } catch (err) {}
    },
    async save() {
      this.isLoadingSave = true;
      try {
        const { data } = await this.$axios.post("/roles/save", {
          ...this.form,
          permissions: this.permissions,
        });

        if (data.success) {
          this.toastSuccess(data.message);
          this.closeForm();
        } else {
          this.toastError(data.msg);
        }
        this.isLoadingSave = false;
      } catch (err) {
        this.toastError("Something went wrong!");
        this.isLoadingSave = false;
      }
    },
    closeForm() {
      this.$root.$emit("roles:close-modal");
      this.$root.$emit("roles:reload-table");
    },
  },
};
</script>
