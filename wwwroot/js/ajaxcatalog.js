let select = document.getElementById("categoryId");
select.onchange = ChangeSelect;

function ChangeSelect() {
  let categoryId = select.value;
  fetchProducts(categoryId);
}