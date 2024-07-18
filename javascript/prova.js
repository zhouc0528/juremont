  // prova.js is generated by ChatGPT

  function toggleFreightCost() {
    const freightType = document.querySelector('input[name="freighttype"]:checked').value;
    const freightCostSection = document.getElementById('freightCostSection');
    if (freightType === 'airfreight') {
      freightCostSection.style.display = 'block';
    } else {
      freightCostSection.style.display = 'none';
    }
  }

  function togglePallets() {
    const freightType = document.querySelector('input[name="freighttype"]:checked').value;
    const palletsSection = document.getElementById('palletquantity');
    if (freightType === 'LCL') {
      palletsSection.style.display = 'block';
    } else {
      palletsSection.style.display = 'none';
    }
  }
  
  function toggleNewBusiness() {
    const customerType = document.querySelector('input[name="customertype"]:checked').value;
    // No need for any additional elements to show/hide for New Business
  }
  
  function toggleStorageWeeks() {
    const shipTo = document.querySelector('input[name="shipto"]:checked').value;
    const storageWeeksSection = document.getElementById('storageWeeksSection');
    const customerLocationSection = document.getElementById('customerLocationSection');
  
    if (shipTo === 'warehouse') {
      storageWeeksSection.style.display = 'block';
      //customerLocationSection.style.display = 'none';
    } else {
      storageWeeksSection.style.display = 'none';
      //customerLocationSection.style.display = 'block';
    }
  }
  
  document.addEventListener('DOMContentLoaded', function() {
    toggleFreightCost();
    toggleStorageWeeks();
    togglePallets();
  });
  