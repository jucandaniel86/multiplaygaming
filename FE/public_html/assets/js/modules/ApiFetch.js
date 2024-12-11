export const __ApiFetch = async (url, data) => {
  try {
    const response = await fetch(url + '?' + decodeURIComponent(new URLSearchParams(data).toString()), {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      }
    });
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return await response.json();
  } catch (error) {
    console.error('Error:', error);
  }
}
