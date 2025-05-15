$(document).ready(function () {
    let productIndex = 1;

    function loadProducts(fromStoreId, $select) {
        $.ajax({
            url: GET_PRODUCTS_BY_STORE_URL,
            method: 'POST',
            data: { store_id: fromStoreId },
            dataType: 'json',
            success: function (products) {
                let options = '<option value="">-- Select Product --</option>';
                products.forEach(function (product) {
                    options += `<option value="${product.product_id}">${product.productName}</option>`;
                });
                $select.html(options);
            }
        });
    }

    $('#fromStoreId').on('change', function () {
        let fromStoreId = $(this).val();
        $('#productTableBody .product-select').each(function () {
            loadProducts(fromStoreId, $(this));
        });
    });

    $('#productTable').on('change', '.product-select', function () {
        let $row = $(this).closest('tr');
        let formProductId = $(this).val();
        let fromStoreId = $('#fromStoreId').val();
        let toStoreId = $('#toStoreId').val();

        if (!fromStoreId) {
            alert('Please select From Store first.');
            $(this).val("");
            $row.find('.available-qty').val("");
            return;
        }

        if (formProductId && toStoreId) {
            $.ajax({
                url: TRANSFER_CHECK_URL,
                method: 'POST',
                data: {
                    product_id: formProductId,
                    form_store_id: fromStoreId,
                    to_store_id: toStoreId
                },
                dataType: 'json',
                success: function (res) {
                    console.log("AJAX Response:", res);
                    if (res.exists) {
                        $row.find('.available-qty').val(res.available_quantity);
                    } else {
                        alert('This product does not exist in the selected To Store.');
                        $row.find('.available-qty').val("");
                    }
                },
                error: function (xhr) {
                    console.error("AJAX Error:", xhr.responseText);
                }
            });
        } else {
            $row.find('.available-qty').val("");
        }
    });

    $('#addRow').on('click', function () {
        let fromStoreId = $('#fromStoreId').val();
        if (!fromStoreId) {
            alert('Please select From Store first.');
            return;
        }

        let rowHtml = `
            <tr>
                <td>
                    <select name="products[${productIndex}][product_id]" class="form-control product-select" data-index="${productIndex}">
                        <option value="">-- Select Product --</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="products[${productIndex}][available_quantity]" class="form-control available-qty" readonly>
                </td>
                <td>
                    <input type="number" name="products[${productIndex}][quantity]" class="form-control" required min="1">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm removeRow">Remove</button>
                </td>
            </tr>`;
        $('#productTableBody').append(rowHtml);
        loadProducts(fromStoreId, $(`select[data-index="${productIndex}"]`));
        productIndex++;
    });

    $('#productTable').on('click', '.removeRow', function () {
        $(this).closest('tr').remove();
    });

    $('#transferForm').on('submit', function (e) {
        e.preventDefault();

        let fromStore = $('#fromStoreId').val();
        let toStore = $('#toStoreId').val();

        if (fromStore === toStore) {
            alert("From Store and To Store must be different.");
            return;
        }

        let products = [];
        let valid = true;

        $('#productTableBody tr').each(function () {
            let productId = $(this).find('.product-select').val();
            let quantity = parseInt($(this).find('input[name*="[quantity]"]').val());
            let availableQty = parseInt($(this).find('.available-qty').val());

            if (!productId || !quantity) {
                valid = false;
                return false; // break
            }

            if (quantity > availableQty) {
                alert('Transfer quantity cannot exceed available quantity.');
                valid = false;
                return false;
            }

            products.push({
                product_id: productId,
                quantity: quantity,
                availableQuantity: availableQty
            });
        });

        if (!valid || products.length === 0) {
            alert("Please correct the form. All products must be selected with a valid quantity.");
            return;
        }

        let payload = {
            fromStoreId: fromStore,
            toStoreId: toStore,
            status: $('#status').val(),
            specialNotes: $('#specialNotes').val(),
            products: products
        };

        $.ajax({
            url: TRANSFER_PRO_URL,
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(payload),
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    alert('Transfer successful!');
                    location.reload();
                } else {
                    alert('Transfer failed: ' + response.message);
                }
            },
            error: function (xhr) {
                alert('Server error: ' + xhr.responseText);
            }
        });
    });
});


// $(document).ready(function () {
//     let productIndex = 1;

//     $('#productTable').on('change', '.product-select', function () {
//         let $row = $(this).closest('tr');
//         let formProductId = $(this).val();
//         let fromStoreId = $('#fromStoreId').val();
//         let toStoreId = $('#toStoreId').val();

//         if (!fromStoreId) {
//             alert('Please select From Store first.');
//             $(this).val("");
//             $row.find('.available-qty').val("");
//             return;
//         }

//         if (formProductId && toStoreId) {
//             $.ajax({
//                 url: TRANSFER_CHECK_URL,
//                 method: 'POST',
//                 data: {
//                     product_id: formProductId,
//                     form_store_id: fromStoreId,
//                     to_store_id: toStoreId
//                 },
//                 dataType: 'json',
//                 success: function (res) {
//                     console.log(res);
//                     if (res.exists) {
//                         // $row.find('.product-select').val(res.product_id); 
//                         $row.find('.available-qty').val(res.available_quantity);
//                     } else {
//                         alert('This product is not exists in the selected To Store.');
//                     }
//                 },
//                 error: function () {
//                     alert('Error checking product or quantity');
//                 }
//             });

//         } else {
//             $row.find('.available-qty').val("");
//         }
//     });



//     // Re-trigger product quantity fetch when store changes 
//     $('#fromStoreId').on('change', function () {
//         $('.product-select').each(function () {
//             if ($(this).val()) {
//                 $(this).trigger('change');
//             }
//         });
//     });
    

//     // Add new row with validation
//     $('#addRow').on('click', function () {
//         let fromStoreId = $('#fromStoreId').val();
//         if (!fromStoreId) {
//             alert('Please select From Store first.');
//             return;
//         }

//         // Validate last row input
//         let lastRow = $('#productTableBody tr').last();
//         let selectedProduct = lastRow.find('.product-select').val();
//         let availableQty = lastRow.find('.available-qty').val();
//         let transferQty = lastRow.find('input[name*="[quantity]"]').val();

//         if (!selectedProduct) {
//             alert('Please select a product before adding another row.');
//             return;
//         }

//         if (!availableQty || parseInt(availableQty) <= 0) {
//             alert('Selected product is out of stock or unavailable.');
//             return;
//         }

//         if (!transferQty) {
//             alert('Transfer quantity is required.');
//             return;
//         }

//         // Check for duplicate products
//         let selectedProducts = [];
//         $('.product-select').each(function () {
//             selectedProducts.push($(this).val());
//         });

//         if (new Set(selectedProducts).size !== selectedProducts.length) {
//             alert('Each product can only be selected once.');
//             return;
//         }
//         let rowHtml = `
//         <tr>
//             <td>
//                 <select name="products[${productIndex}][product_id]" class="form-control product-select" data-index="${productIndex}">
//                     <option value="">-- Select Product --</option>
//                     ${PRODUCT_OPTIONS}
//                 </select>
//             </td>
//             <td>
//                 <input type="text" name="products[${productIndex}][available_quantity]" class="form-control available-qty" readonly>
//             </td>
//             <td>
//                 <input type="number" name="products[${productIndex}][quantity]" class="form-control" required min="1">
//             </td>
//             <td>
//                 <button type="button" class="btn btn-danger btn-sm removeRow">Remove</button>
//             </td>
//         </tr>
//     `;

//         $('#productTableBody').append(rowHtml);
//         productIndex++;
//     });

//     // Handle form submit
//     $('#transferForm').on('submit', function (e) {
//         e.preventDefault();

//         let fromStore = $('#fromStoreId').val();
//         let toStore = $('#toStoreId').val();

//         if (fromStore === toStore) {
//             alert("From Store and To Store must be different.");
//             return;
//         }

//         let products = [];
//         $('#productTableBody tr').each(function () {
//             let productId = $(this).find('.product-select').val();
//             let quantity = $(this).find('input[name*="[quantity]"]').val();
//             let available_quantity = $(this).find('.available-qty').val();
//             if (productId && quantity) {
//                 products.push({
//                     product_id: productId,
//                     quantity: quantity,
//                     availableQuantity: available_quantity
//                 });
//             }
//         });

//         if (products.length === 0) {
//             alert("Please select at least one product with quantity.");
//             return;
//         }

//         let payload = {
//             fromStoreId: fromStore,
//             toStoreId: toStore,
//             status: $('#status').val(),
//             specialNotes: $('#specialNotes').val(),
//             products: products
//         };

//         $.ajax({
//             url: TRANSFER_PRO_URL,
//             type: 'POST',
//             contentType: 'application/json',
//             data: JSON.stringify(payload),
//             dataType: 'json',
//             success: function (response) {
//                 if (response.status === 'success') {
//                     alert('Transfer successful!');
//                     location.reload();
//                 } else {
//                     alert('Transfer failed: ' + response.message);
//                 }
//             },
//             error: function (xhr) {
//                 console.error(xhr.responseText);
//                 alert('Transfer failed due to server error.');
//             }
//         });
//     });

//     // Remove row
//     $('#productTable').on('click', '.removeRow', function () {
//         $(this).closest('tr').remove();
//     });

//     // for update data 
//     // $(document).ready(function() { 
//     //     $('#submitBtn').click(function(e) {
//     //         e.preventDefault();

//     //         var empId = $('#editempId').val();
//     //         var form = $('#employeeForm')[0];
//     //         var formData = new FormData(form);
//     //         var url = empId ? TRANSFER_UPDATE_URL + empId : TRANSFER_ADD_URL;

//     //         $.ajax({
//     //             url: url,
//     //             type: 'POST',
//     //             data: formData,
//     //             contentType: false,
//     //             processData: false,
//     //             success: function(response) {
//     //                 if (!response.success ) {
//     //                     $.each(response.errors, function(key, val) {
//     //                         $('.error-' + key).text(val);
//     //                     })
//     //                 } else {
//     //                     let data = JSON.parse(response);
//     //                     // console.log(data);
//     //                     $('#employeeForm')[0].reset();
//     //                     $('#editempId').val('');
//     //                     if (typeof table !== 'undefined') {
//     //                         table.ajax.reload();
//     //                     }
//     //                     window.location.href = "<?= base_url('employee') ?>";
//     //                 }
//     //             }   
//     //         });
//     //     });
//     // });



//     // If product does not exist in To Store, load available quantity
//     //     $.ajax({
//     //                         url: TRANSFER_GET_URL,
//     //                         method: 'POST',
//     //                         data: {
//     //                             product_id: productId,
//     //                             store_id: fromStoreId
//     //                         },
//     //                         dataType: 'json',
//     //                         success: function (qtyRes) {
//     //                             $row.find('.available-qty').val(qtyRes.available_quantity);
//     //                         },
//     //                         error: function () {
//     //                             alert('Error getting quantity');
//     //                         }
//     //                     });
// });