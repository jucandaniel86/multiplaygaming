<script>
export default {
  name: 'IndexPage',
  async created() {
    if(this.$auth.loggedIn) {
			return this.$router.push({ name: 'dashboard' });
		}
		return this.$router.push({ name: 'auth-login' });
  },
}
</script>
