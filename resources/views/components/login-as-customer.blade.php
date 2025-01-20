
<button class="px-4 py-2 bg-blue-500 text-white rounded" onclick="copyToClipboard('{{ $magicUrl }}')">
  Login as Customer
</button>

<script>
  function copyToClipboard(url) {
    const tempInput = document.createElement('input');
    document.body.appendChild(tempInput);
    tempInput.value = url;
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);
    alert('Magic URL copied to clipboard!');
  }

</script>
