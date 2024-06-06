function sortTable(column, asc=true){
    const ascOrNot = asc ? 1 : -1;
    const elements = document.getElementById('Education').tBodies[0];
    const rows = Array.from(elements.querySelectorAll('tr'));
    const sorted = rows.sort((a, b)=>{
      const textA = a.querySelector(`td:nth-child(${column + 1})`).textContent.trim();
      const textB = b.querySelector(`td:nth-child(${column + 1})`).textContent.trim();
      return textA > textB ? (1 * ascOrNot) : (-1 * ascOrNot);
    });
    while (elements.firstChild) {
      elements.removeChild(elements.firstChild)
    };
    elements.append(...sorted);
    document.getElementById('Education').querySelectorAll('th').forEach(th=>th.classList.remove("th-sort-asc","th-sort-desc"));
    document.getElementById('Education').querySelector(`th:nth-child(${column+1})`).classList.toggle("th-sort-asc",asc);
    document.getElementById('Education').querySelector(`th:nth-child(${column+1})`).classList.toggle("th-sort-desc",!asc);
  }
  function sortTableCreditHours(column, asc=true){
    const ascOrNot = asc ? 1 : -1;
    const elements = document.getElementById('Education').tBodies[0];
    const rows = Array.from(elements.querySelectorAll('tr'));
    const sorted = rows.sort((a, b)=>{
      const A = parseInt(a.querySelector(`td:nth-child(${column + 1})`).textContent);
      const B = parseInt(b.querySelector(`td:nth-child(${column + 1})`).textContent);
      return A > B ? (1 * ascOrNot) : (-1 * ascOrNot);
    });
    while (elements.firstChild) {
      elements.removeChild(elements.firstChild)
    };
    elements.append(...sorted);
    document.getElementById('Education').querySelectorAll('th').forEach(th=>th.classList.remove("th-sort-asc","th-sort-desc"));
    document.getElementById('Education').querySelector(`th:nth-child(${column+1})`).classList.toggle("th-sort-asc",asc);
    document.getElementById('Education').querySelector(`th:nth-child(${column+1})`).classList.toggle("th-sort-desc",!asc);
  }
  document.getElementById('Education').querySelectorAll('th').forEach((th, index)=>{
    th.addEventListener('click',()=>{
      const containASC = th.classList.contains("th-sort-asc");
      if(containASC)
        th.classList.toggle("th-sort-desc");
    else
        th.classList.toggle("th-sort-asc");
      if(index === document.getElementById('Education').querySelectorAll('th').length - 2){
        sortTableCreditHours(index,!containASC);
      }else{
        sortTable(index,!containASC);
      }
    })
  });
const addCertificationModal = document.getElementById('addCertificationModal');
const editCertificationBtns = document.querySelectorAll('.edit-certification-btn');
const institution = document.getElementById('institution');
const document_type = document.getElementById('document_type');
const document_link = document.getElementById('document_link');
const topic = document.getElementById('topic');
const date_begin = document.getElementById('date_begin');
const date_end = document.getElementById('date_end');
const credit_hours = document.getElementById('credit_hours');
const btnFrom = document.getElementById('btnFrom');
const addCertificationModalLabel = document.getElementById('addCertificationModalLabel');
addCertificationModal.addEventListener('hidden.bs.modal', function() {
    institution.value = "";
    document_type.value = "";
    topic.value = "";
    date_begin.value = "";
    date_end.value = "";
    credit_hours.value = "";
    document_link.value="";
    btnFrom.name = 'add';
    btnFrom.value = null;
    btnFrom.innerText = "Додати";
    addCertificationModalLabel.innerText = "Додати запис"; 
});
editCertificationBtns.forEach(button => {
  button.addEventListener('click', function() {
    institution.value = this.dataset.institution;
    document_type.value = this.dataset.documentType;
    document_link.value=this.dataset.linkToDoc;
    topic.value = this.dataset.topic;
    date_begin.value = this.dataset.dateBegin;
    date_end.value = this.dataset.dateEnd;
    credit_hours.value = this.dataset.creditHours;
    btnFrom.name = 'change';
    btnFrom.value = this.dataset.certificationId;
    btnFrom.innerText = "Змінити";
    addCertificationModalLabel.innerText = "Змінити запис"; 
  });
});