export const __initGameTabs = () => {
  const $tabs = $('.tab-link_games');
  if ($tabs.length === 0) return false;

  const openTab = (_event) => {
    const currentTab = $(_event.currentTarget);
    $tabs.removeClass('w--current');
    currentTab.addClass('w--current');
  }

  $tabs.on('click', (e) => openTab(e));
}
