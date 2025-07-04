document.addEventListener("DOMContentLoaded", function() {

    // Charger les bases
    fetch('fetch_data.php?action=bases')
        .then(response => response.json())
        .then(data => {
            console.log("BASES:", data);
            const baseSelect = document.getElementById('base');
            baseSelect.innerHTML = '<option value="">choisissez une institution</option>';
            data.forEach(item => {
                baseSelect.innerHTML += `<option value="${item.id}">${item.nom}</option>`;
            });
        });
    });
    // Quand je change la base → charger parcours
document.addEventListener("DOMContentLoaded", function() {

    // Charger TOUS les parcours au chargement
    fetch('fetch_data.php?action=parcours')
        .then(response => response.json())
        .then(data => {
            console.log("PARCOURS:", data); // Debug
            const parcoursSelect = document.getElementById('parcours');
            parcoursSelect.innerHTML = '<option value="">Selectionnez une faculter ou filière</option>';
            data.forEach(item => {
                parcoursSelect.innerHTML += `<option value="${item.id}">${item.nom}</option>`;
            });
        });

});
  
document.addEventListener("DOMContentLoaded", function() {

    // Charger les niveaux au chargement
    fetch('fetch_data.php?action=niveaux')
        .then(response => response.json())
        .then(data => {
            console.log("NIVEAUX:", data); // Debug
            const niveauSelect = document.getElementById('niveau');
            niveauSelect.innerHTML = '<option value="">Sélectionnez un niveau</option>';
            data.forEach(item => {
                niveauSelect.innerHTML += `<option value="${item.id}">${item.nom}</option>`;
            });
        });

});

document.addEventListener("DOMContentLoaded", function() {

    // Charger les années au chargement
    fetch('fetch_data.php?action=annees')
        .then(response => response.json())
        .then(data => {
            console.log("ANNEES:", data); // Debug
            const anneeSelect = document.getElementById('annee');
            anneeSelect.innerHTML = '<option value="">Sélectionnez une année académique</option>';
            data.forEach(item => {
                anneeSelect.innerHTML += `<option value="${item.id}">${item.annee}</option>`;
            });
        });

});
document.getElementById('photo').addEventListener('change', function (e) {
      const file = e.target.files[0];
      const preview = document.getElementById('preview');

      if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function (event) {
          preview.src = event.target.result;
          preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
      } else {
        preview.src = '';
        preview.style.display = 'none';
      }
    });

function rechercherEtudiant() {
    const nom = prompt("Entrez le nom de l'étudiant à rechercher :");
    if (nom) {
        // Envoyer une requête AJAX pour rechercher l'étudiant
        fetch(`rechercher.php?nom=${encodeURIComponent(nom)}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Afficher les informations de l'étudiant
                    document.getElementById('message').innerHTML = JSON.stringify(data.etudiant);
                } else {
                    alert("Étudiant non trouvé.");
                }
            })
            .catch(error => console.error('Erreur:', error));
    }
}

function modifierEtudiant() {
    const id = prompt("Entrez l'ID de l'étudiant à modifier :");
    if (id) {
        // Rediriger vers une page de modification
        window.location.href = `modifier.php?id=${id}`;
    }
}

function supprimerEtudiant() {
    const id = prompt("Entrez l'ID de l'étudiant à supprimer :");
    if (id && confirm("Êtes-vous sûr de vouloir supprimer cet étudiant ?")) {
        // Envoyer une requête AJAX pour supprimer l'étudiant
        fetch(`supprimer.php?id=${id}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Étudiant supprimé avec succès.");
                } else {
                    alert("Erreur lors de la suppression de l'étudiant.");
                }
            })
            .catch(error => console.error('Erreur:', error));
    }
}


/**document.addEventListener("DOMContentLoaded", function() {

    // Charger les bases au début
    fetch('fetch_data.php?action=bases')
        .then(response => response.json())
        .then(data => {
            const baseSelect = document.getElementById('base');
            baseSelect.innerHTML = '<option value="">-- Sélectionnez une base --</option>';
            data.forEach(item => {
                baseSelect.innerHTML += `<option value="${item.id}">${item.nom}</option>`;
            });
        });

    // Quand on choisit une Base → charger Parcours
    document.getElementById('base').addEventListener('change', function() {
        const baseId = this.value;

        fetch(`fetch_data.php?action=parcours&id_base=${baseId}`)
            .then(response => response.json())
            .then(data => {
                const parcoursSelect = document.getElementById('parcours');
                parcoursSelect.innerHTML = '<option value="">-- Sélectionnez un parcours --</option>';
                data.forEach(item => {
                    parcoursSelect.innerHTML += `<option value="${item.id}">${item.nom}</option>`;
                });
            });
    });

    // Quand on choisit un Parcours → charger Niveaux + Annees
    document.getElementById('parcours').addEventListener('change', function() {
        const parcoursId = this.value;

        fetch(`fetch_data.php?action=niveau&id_parcours=${parcoursId}`)
            .then(response => response.json())
            .then(data => {
                const niveauSelect = document.getElementById('niveau');
                niveauSelect.innerHTML = '<option value="">-- Sélectionnez un niveau --</option>';
                data.forEach(item => {
                    niveauSelect.innerHTML += `<option value="${item.id}">${item.nom}</option>`;
                });
            });

        // Chargement des Années académique (si général ou par parcours)
        fetch(`fetch_data.php?action=annees`)
            .then(response => response.json())
            .then(data => {
                const anneeSelect = document.getElementById('annee');
                anneeSelect.innerHTML = '<option value="">-- Sélectionnez une année académique --</option>';
                data.forEach(item => {
                    anneeSelect.innerHTML += `<option value="${item.id}">${item.libelle}</option>`;
                });
            });
    });

    // Aperçu de la photo
    document.getElementById('photo').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

**/









/**document.addEventListener("DOMContentLoaded", function() {
    // Chargement initial des Bases
    fetch('fetch_data.php?action=bases')
        .then(response => response.json())
        .then(data => {
            let baseSelect = document.getElementById('base');
            baseSelect.innerHTML = '<option value="">-- Sélectionnez une base --</option>';
            data.forEach(item => {
                baseSelect.innerHTML += `<option value="${item.id}">${item.nom}</option>`;
            });
        });

    // Lorsque je choisis une Base → charger les Parcours
    document.getElementById('base').addEventListener('change', function() {
        let baseId = this.value;
        if (baseId) {
            fetch(`fetch_data.php?action=parcours&id_base=${baseId}`)
                .then(response => response.json())
                .then(data => {
                    let parcoursSelect = document.getElementById('parcours');
                    parcoursSelect.innerHTML = '<option value="">-- Sélectionnez un parcours --</option>';
                    data.forEach(item => {
                        parcoursSelect.innerHTML += `<option value="${item.id}">${item.nom}</option>`;
                    });
                });
        }
    });

    // Lorsque je choisis un Parcours → charger les Niveaux
    document.getElementById('parcours').addEventListener('change', function() {
        let parcoursId = this.value;
        if (parcoursId) {
            fetch(`fetch_data.php?action=niveaux&id_parcours=${parcoursId}`)
                .then(response => response.json())
                .then(data => {
                    let niveauSelect = document.getElementById('niveau');
                    niveauSelect.innerHTML = '<option value="">-- Sélectionnez un niveau --</option>';
                    data.forEach(item => {
                        niveauSelect.innerHTML += `<option value="${item.id}">${item.nom}</option>`;
                    });
                });
        }
    });

    // Chargement initial des Années académiques
    fetch('fetch_data.php?action=annees')
        .then(response => response.json())
        .then(data => {
            let anneeSelect = document.getElementById('annee');
            anneeSelect.innerHTML = '<option value="">-- Sélectionnez une année académique --</option>';
            data.forEach(item => {
                anneeSelect.innerHTML += `<option value="${item.id}">${item.libelle}</option>`;
            });
        });
}); **/







/**function fetchOptions(url, selectId) {
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById(selectId);
            select.innerHTML = '<option value="">choisissez une institution</option>';
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.nom || item.libelle || item.titre;
                select.appendChild(option);
            });
        });
}

document.addEventListener('DOMContentLoaded', function () {
    fetchOptions('fetch_data.php?action=bases', 'base');

    document.getElementById('base').addEventListener('change', function () {
        fetchOptions('fetch_data.php?action=parcours&id_base=' + this.value, 'parcours');
    });

    document.getElementById('parcours').addEventListener('change', function () {
        fetchOptions('fetch_data.php?action=niveaux&id_parcours=' + this.value, 'niveau');
        fetchOptions('fetch_data.php?action=annees&id_parcours=' + this.value, 'annee');
    });

    document.getElementById('photo').addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById('photoPreview');
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
});
fetch('fetch_data.php?action=bases')
    .then(response => response.json())
    .then(data => {
        console.log(data); // ← ajout temporaire
        let selectBase = document.getElementById('base');
        selectBase.innerHTML = '<option value="">Sélectionner une base</option>';
        data.forEach(item => {
            selectBase.innerHTML += `<option value="${item.id}">${item.nom}</option>`;
        });
    });
**/



/**document.addEventListener("DOMContentLoaded", () => {
  // Charger les bases au démarrage
  fetchData("Base", "base");

  // Quand on sélectionne une base
  document.getElementById("base").addEventListener("change", function () {
    const baseId = this.value;

    // Réinitialiser les champs dépendants
    resetSelect("niveau");
    resetSelect("parcours");
    resetSelect("annee");

    if (baseId) {
      fetchData("Niveau", "niveau", baseId);
      fetchData("Parcours", "parcours", baseId);
      fetchData("AnneeAcademique", "annee", baseId);
    }
  });
});

function fetchData(type, selectId, baseId = null) {
  let url = `fetch_data.php?table=${type}`;
  if (baseId) {
    url += `&base_id=${baseId}`;
  }

  fetch(url)
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById(selectId);
      data.forEach(item => {
        const opt = document.createElement("option");
        opt.value = item.id;
        opt.textContent = item.nom || item.libelle || item.titre;
        select.appendChild(opt);
      });
    })
    .catch(error => console.error("Erreur de chargement :", error));
}

function resetSelect(id) {
  const select = document.getElementById(id);
  select.innerHTML = '<option value="">-- Sélectionner --</option>';
}**/

/**document.addEventListener("DOMContentLoaded", function () {
    // Prévisualisation de la photo
    const photoInput = document.getElementById("photo");
    const preview = document.getElementById("preview");

    photoInput.addEventListener("change", function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    });

    // Recherche par nom ou email
    const searchInput = document.getElementById("searchInput");
    const tableRows = document.querySelectorAll(".etudiant-row");

    if (searchInput) {
        searchInput.addEventListener("input", function () {
            const value = this.value.toLowerCase();
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(value) ? "" : "none";
            });
        });
    }

    // Supprimer/Modifier (à implémenter dans le HTML avec attributs data-id)
});**/










// Charger institutions, année académique, niveaux
/**window.onload = () => {
    fetch('fetch_data.php')
        .then(res => res.json())
        .then(data => {
            populateSelect('base', data.institutions);
            populateSelect('annee', data.annees);
            populateSelect('niveau', data.niveaux);
        });

    // Changement d'institution => charger parcours
    document.getElementById('base').addEventListener('change', () => {
        const baseId = document.getElementById('base').value;
        fetch(`get_parcours.php?base_id=${baseId}`)
            .then(res => res.json())
            .then(data => populateSelect('parcours', data));
    });

    // Aperçu photo
    document.getElementById('photo').addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const preview = document.getElementById('photoPreview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = "block";
        }
    });
};

function populateSelect(id, items) {
    const select = document.getElementById(id);
    select.innerHTML = '<option value="">-- Choisissez --</option>';
    items.forEach(item => {
        const option = document.createElement('option');
        option.value = item.id;
        option.textContent = item.nom;
        select.appendChild(option);
    });
}**/