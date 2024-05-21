// Función para mostrar el cuadro de confirmación
function showConfirmation(id) {
    // Mostrar el modal
    var modal = document.getElementById("confirmModal");
    modal.style.display = "block";
    
    // Guardar el ID del registro que se va a eliminar en un campo oculto dentro del modal
    document.getElementById("recordId").value = id;
  }
  
  // Función para cerrar el cuadro de confirmación
  function closeModal() {
    // Ocultar el modal
    var modal = document.getElementById("confirmModal");
    modal.style.display = "none";
  }
  
  // Función para eliminar el registro
  function deleteRecord() {
    // Obtener el ID del registro a eliminar desde el campo oculto dentro del modal
    var id = document.getElementById("recordId").value;
    
    // Redirigir a la página de eliminar_personal.php con el ID del registro como parámetro
    window.location.href = "eliminar_personal.php?id=" + id;
  }
  