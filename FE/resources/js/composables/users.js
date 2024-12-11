import {ref} from 'vue';
import axios from "axios";

import useHelper from "./helper";

export default function useUsers() {
  const user = ref(null);
  const userLoading = ref(false);

  const getUser = async (_data) => {
    userLoading.value = true;
    try {
      const {data} = await axios.get('/me');
      if (data) {
        user.value = data;
      }
    } catch (err) {
      console.log('useUsers(): ', err);
    }
    userLoading.value = false;
  }

  const updateUserDetails = async (_data) => {
    const {validObjectProp} = useHelper();
    let response = null;
    try {
      const {data} = await axios.post('/ca-api/update-user-details', _data);
      response = data;
    } catch (err) {
      console.log('useUsers()::updateUserDetails():', err);
      if (validObjectProp(err, 'response.data')) {
        response = err.response.data;
      }
    }
    return response;
  }

  const sendSupport = async (_data) => {
    const {validObjectProp} = useHelper();
    let response = null;
    try {
      const {data} = await axios.post('/ca-api/support', _data);
      response = data;
    } catch (err) {
      console.log('useUsers()::updateUserDetails():', err);
      if (validObjectProp(err, 'response.data')) {
        response = err.response.data;
      }
    }
    return response;
  }

  return {
    user,
    userLoading,
    getUser,
    updateUserDetails,
    sendSupport
  }
}
