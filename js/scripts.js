// Mostra os dados do convênio só quando o paciente marcar "Sim".
 
document.addEventListener('DOMContentLoaded', () => {
  const dadosConvenio = document.getElementById('dadosConvenio');
  const radios = document.querySelectorAll('input[name="tem_convenio"]');
 
  if (!dadosConvenio || radios.length === 0) return;
 
  function atualizarConvenio() {
    const temConvenio = document.getElementById('convenio_sim').checked;
 
    dadosConvenio.classList.toggle('d-none', !temConvenio);
 
    // Campos escondidos ficam desabilitados e não vão no POST
    dadosConvenio.querySelectorAll('input').forEach((campo) => {
      campo.disabled = !temConvenio;
    });
  }
 
  radios.forEach((radio) => radio.addEventListener('change', atualizarConvenio));
 
  atualizarConvenio();
});