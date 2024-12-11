<script setup>
import {ref, reactive, onMounted, watch} from 'vue';
import {useMainStore} from "../stores/main";
import useUsers from "../composables/users";

const loader = ref(false);
const breadcrumbs = ref([
  {
    title: 'Client Area',
    disabled: false,
    to: {name: 'ca.index'}
  },
  {
    title: 'Account',
    disabled: true,
    href: '#'
  },
]);
const form = reactive({
  first_name: '',
  last_name: '',
});
const errors = ref([]);
const success = ref(false);
const message = ref('');
const {updateUserDetails, user, userLoading, getUser} = useUsers();
const mainStore = useMainStore();
mainStore.SET_BREADCRUMBS(breadcrumbs);

const onSubmit = async () => {
  loader.value = true;
  const data = await updateUserDetails(form);

  if (data.errors) {
    errors.value = data.errors;
  }
  if (data.success) {
    success.value = true;
    message.value = data.msg;

    setTimeout(() => {
      success.value = false;
      message.value = '';
    }, 3000);
  }
  loader.value = false;
}

onMounted(getUser);

watch(user, () => {
  form.last_name = user.value.last_name;
  form.first_name = user.value.first_name;

})

</script>
<template>
  <v-card color="white" elevation="1">
    <v-card-title>
      <h3 class="text-h5">My Account</h3>
    </v-card-title>
    <v-card-subtitle class="font-weight-black">Personal Details</v-card-subtitle>
    <v-card-text>
      <v-snackbar v-model="success" color="green" position="sticky" location="top">
        {{ message }}
      </v-snackbar>
      <v-text-field
        label="First Name"
        v-model="form.first_name"
        :error="errors.first_name"
        :error-messages="errors.first_name"
        :disabled="userLoading"
      />
      <v-text-field
        label="Last Name"
        v-model="form.last_name"
        :error="errors.last_name"
        :error-messages="errors.last_name"
        :disabled="userLoading"
      />
      <v-btn
        color="primary"
        @click.prevent="onSubmit"
        :disabled="loader || userLoading"
      >Update Details
      </v-btn>
    </v-card-text>
    <v-card-subtitle class="font-weight-black">Change password</v-card-subtitle>
    <v-card-text>
      <p>You will receive an e-mail with a link that would allow changing your password</p>
      <v-btn
        color="primary"
        class="mt-2"
      >Change password
      </v-btn>
    </v-card-text>
  </v-card>
</template>
