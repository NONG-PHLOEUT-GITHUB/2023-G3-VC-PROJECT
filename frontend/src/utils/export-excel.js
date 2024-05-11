// Define a function to export Excel file
function exportExcel(data, filename) {
  // Create a Blob from the response data
  const blob = new Blob([data], {
    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
  })
  const url = window.URL.createObjectURL(blob)

  // Create a link element to trigger the download
  const link = document.createElement('a')
  link.href = url
  link.setAttribute('download', filename) // Set filename dynamically

  // Append the link to the document body and trigger the click event
  document.body.appendChild(link)
  link.click()

  // Clean up by revoking the Object URL
  window.URL.revokeObjectURL(url)
}

