<a class="scroll-to-top rounded cl-white" href="#page-top">
    <i class="ti-angle-double-up"></i>
</a>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<!-- Core plugin JavaScript -->
<script src="{{ asset('assets/plugins/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('assets/plugins/slim-scroll/jquery.slimscroll.min.js') }}"></script>

<!-- Bootstrap JS -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Input mask -->
<script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<!-- Plugins divers -->
<script src="{{ asset('assets/plugins/slick-slider/slick.js') }}"></script>
<script src="{{ asset('assets/plugins/validator/validator.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('assets/plugins/fastclick/fastclick.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>

<!-- Angular Tooltip (Angular avant plugins Angular) -->
<script src="{{ asset('assets/plugins/angular-tooltip/angular.js') }}"></script>
<script src="{{ asset('assets/plugins/angular-tooltip/angular-tooltips.js') }}"></script>

<!-- PdfObject -->
<script src="{{ asset('assets/apiReader/pdfobject.min.js') }}"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Scripts personnalisés -->
<script src="{{ asset('assets/dist/js/adminfier.js') }}"></script>
<script src="{{ asset('assets/dist/js/custom/form-element.js') }}"></script>
<script src="{{ asset('assets/dist/js/custom/form-wizard.js') }}"></script>
<script src="{{ asset('assets/dist/jsFile/custom-file-input.js') }}"></script>

<!-- générer un PDF avec html2pdf   -->


<!-- Custom scripts for all pages -->
<script src="{{ asset('assets/dist/js/adminfier.js') }}"></script>
<script src="{{ asset('assets/dist/js/jQuery.style.switcher.js') }}"></script>

<!-- Validator JavaScript -->
<script src="{{ asset('assets/plugins/validator/validator.js') }}"></script>
<script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>

<!-- Select2 -->

<script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>



<!-- bootstrap datepicker -->
<script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>

<!-- bootstrap color picker -->
<script src="{{ asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>

<!-- bootstrap time picker -->
<script src="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>

<!-- input mask -->
<script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>

<!-- iCheck 1.0.1 -->
<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>



<!-- FastClick -->
<script src="{{ asset('assets/plugins/fastclick/fastclick.js') }}"></script>


<!-- Advance Form Element -->
<script src="{{ asset('assets/dist/js/custom/form-element.js') }}"></script>


<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/dist/js/custom/form-wizard.js') }}"></script>

<!-- Begin API_Reader file -->
<script src="{{ asset('assets/apiReader/pdfobject.js') }}"></script>
<script src="{{ asset('assets/apiReader/pdfobject.min.js') }}"></script>






<!-- End API_Reader file  -->
<script>
    try {

        $('.categorie').val('Simple');
        document.getElementById('dateFinCond1').required = false;
        document.getElementById('dateFinCond2').required = false;
        
    } catch (error) {}

    function openRightMenu() {
        document.getElementById("rightMenu").style.display = "block";
    }

    function closeRightMenu() {
        document.getElementById("rightMenu").style.display = "none";
    }
</script>

<script>
$(document).ready(function() {

    // fonction ajax pour send-audience-recap a partir de js chaque soir a 16h00
    function checkTime() {
        const now = new Date();
        //console.log(`Heure actuelle dans recap audience : ${now.getHours()}:${now.getMinutes()}:${now.getSeconds()}`);
        if (now.getHours() === 13 && now.getMinutes() === 10 && now.getSeconds() === 0) {
            $.ajax({
                type: "GET",
                url: "/send-audience-recap",
                success: function(response) {
                },
                error: function(xhr, status, error) {
                }
            });
        }
    }

    setInterval(checkTime, 1000);

    // Fonction ajax permettante d'envoyer les mails pour completer les suivi d'audiences chaques jours de a 08h30min et 12h00min
    function checkTimeMailSuivi() {
        const now = new Date();
        //console.log(`Heure actuelle dans suivi : ${now.getHours()}:${now.getMinutes()}:${now.getSeconds()}`);

        if (now.getHours() === 17 && now.getMinutes() === 0 && now.getSeconds() === 0) {
            $.ajax({
                type: "GET",
                url: "/send-notification-suivi-audience",
                success: function(response) {
                },
                error: function(xhr, status, error) {
                }
            });
        }
    }

    setInterval(checkTimeMailSuivi, 1000);

    // premier instance

    function premierInstance() {
        const now = new Date();

        if (now.getHours() === 19 && now.getMinutes() === 30 && secondes === 0 && now.getSeconds()=== 0) {
            $.ajax({
                type: "GET",
                url: "/send-notification-suivi-audience-premier_instance",
                success: function(response) {
                    console.log("Réponse serveur :", response);
                    if (response.status === 'info') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Information',
                            text: response.message,
                            timer: 4000,
                            showConfirmButton: false
                        });
                    } else if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Suivi effectué',
                            text: response.message,
                            timer: 4000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Erreur AJAX :", error);
                }
            });
        }
    }

    setInterval(premierInstance, 1000);

    let logoBase64 = null;

    let nomCabinet = "{{ $nomCabinet ?? '' }}";
    
    let dateOuverturePlateforme = "{{ $dateOuverturePlateforme ?? '' }}";
    let planAbonnement = "{{ $planAbonnement ?? '' }}";

    const planDurations = {
        gratuit: 2,
        decouverte: 6,
        classique: 12,
        avance: 18,
        premium: 24
    };

    if (dateOuverturePlateforme && planDurations[planAbonnement]) {

        const today = new Date();
        const startDate = new Date(dateOuverturePlateforme);

        const expirationDate = new Date(startDate);
        expirationDate.setMonth(expirationDate.getMonth() + planDurations[planAbonnement]);

        const diffDays = Math.ceil((expirationDate - today) / (1000 * 60 * 60 * 24));

        const alertDiv = document.getElementById('alertAbonnement');

        if (!alertDiv) return;

        if (diffDays <= 0) {
            alertDiv.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fa fa-times-circle mr-2"></i> Abonnement expiré !</strong>
                    Votre abonnement a expiré. Veuillez le renouveler pour continuer à utiliser la plateforme.
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            `;
        }
        else if (diffDays <= 30) {
            alertDiv.innerHTML = `
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong><i class="fa fa-exclamation-triangle mr-2"></i> Abonnement bientôt expiré !</strong>
                    Il vous reste <strong>${diffDays} jour(s)</strong> avant l’expiration de votre abonnement.
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            `;
        }
    }




    @if (!empty($logoCabinet))
    let logoPath = "{{ $logoCabinet }}"; 


    fetch("{{ url('/') }}/" + logoPath)
        .then(res => {
            if (!res.ok) throw new Error("Image non trouvée !");
            return res.blob();
        })
        .then(blob => {
            let reader = new FileReader();
            reader.onloadend = function () {
                logoBase64 = reader.result;
            }
            reader.readAsDataURL(blob);
        })
        .catch(err => console.error(err));
    @endif



    $('.dataTableExport').DataTable({
        dom: 'Bfrtip',
        searching: true,
        pageLength: 20,
        responsive: true,
        buttons: [
            'copy',
            'csv',
            'excel',
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: ':visible'
                },
                title: function () {
                    let titre = document.title;
                    titre = titre.replace(/-/g, " ").replace(/\s+/g, " ").trim();
                    return titre.split(" ").slice(0, 3).join(" ");
                },
            customize: function (doc) {
                    const now = new Date().toLocaleString('fr-FR', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    // HEADER
                    doc.header = function (currentPage, pageCount) {
                        return {
                            margin: [0, 0, 0, 20],
                            columns: [
                                logoBase64 ? { image: logoBase64, width: 50, margin: [0, 0, 10, 0] } : {},
                                { text: nomCabinet, alignment: 'left', fontSize: 12, bold: true, margin: [0, 15, 0, 0] },
                                { text: 'Téléchargé le : ' + now, alignment: 'right', fontSize: 10, bold: true, margin: [0, 10, 20, 0] }
                            ]
                        };
                    };

                    // FOOTER
                    doc.footer = function (currentPage, pageCount) {
                        return {
                            columns: [
                                {
                                    text: 'www.smartylex.com',
                                    alignment: 'right',
                                    margin: [0, 10, 20, 5],
                                    fontSize: 9,
                                    color: '#003366',
                                    bold: true
                                }
                            ]
                        };
                    };

                    // Styles pour centrer le contenu
                    doc.styles = {
                        header: { fontSize: 18, bold: true, alignment: 'center', margin: [0, 0, 0, 10] },
                        subheader: { fontSize: 14, bold: true, alignment: 'center', margin: [0, 10, 0, 5] }
                    };

                    // CENTRER LES TABLEAUX HORIZONTAL
                    if (doc.content && Array.isArray(doc.content)) {
                        for (let i = 0; i < doc.content.length; i++) {
                            if (doc.content[i] && doc.content[i].table) {

                                // Centrer horizontalement
                                doc.content[i].alignment = 'center';
                                doc.content[i].margin = [0, 20, 0, 0];

                                
                                doc.content[i].table.body[0].forEach(function(cell) {
                                    cell.fillColor = '#009CAA';  // couleur de fond de l'entête
                                    cell.color = 'white';         // couleur du texte dans l'entête
                                    cell.bold = true;             // texte en gras
                                });

                                // Optionnel : envelopper le tableau pour un meilleur centrage
                                doc.content[i] = {
                                    columns: [
                                        { text: '', width: '*' },
                                        { table: doc.content[i].table, width: 'auto' },
                                        { text: '', width: '*' }
                                    ],
                                    margin: [0, 20, 0, 0]
                                };
                            }
                        }
                    }
                    // Marges générales
                    doc.pageMargins = [20, 70, 20, 40]; 

                    // Style par défaut
                    doc.defaultStyle = {
                        fontSize: 10,
                        alignment: 'center'
                    };
                }

            },
            'print'
        ],
        order: []
    });




    var monSwitchButton = document.getElementById("infowitch");

    var elements = document.querySelectorAll(".infoPrive");

        

        for (var i = 0; i < elements.length; i++) {
        elements[i].style.filter = "blur(5px)"; // Ajustez la valeur de flou selon vos besoins
        }
        // Mode prive et public 
        $('#infowitch').on('change', function(e) {
            if (monSwitchButton.checked) {
                // Le switch button est activé
                for (var i = 0; i < elements.length; i++) {
                    elements[i].style.filter = "blur(5px)"; // Ajustez la valeur de flou selon vos besoins
                    }
            } else {
                // Le switch button n'est pas activé
                for (var i = 0; i < elements.length; i++) {
                elements[i].style.filter = ""; // Ajustez la valeur de flou selon vos besoins
                }
            }
        });


    $('#togglePasswordField').click(function(){
        var passwordField = $('#passwordField');
        var fieldType = passwordField.attr('type');

        if(fieldType === 'password') {
            passwordField.attr('type', 'text');
            $('#togglePasswordField').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            $('#togglePasswordField').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#togglePasswordField2').click(function(){
        var passwordField = $('#passwordField2');
        var fieldType = passwordField.attr('type');

        if(fieldType === 'password') {
            passwordField.attr('type', 'text');
            $('#togglePasswordField2').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            $('#togglePasswordField2').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#togglePasswordField3').click(function(){
        var passwordField = $('#passwordField3');
        var fieldType = passwordField.attr('type');

        if(fieldType === 'password') {
            passwordField.attr('type', 'text');
            $('#togglePasswordField3').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            $('#togglePasswordField3').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    /// Pour le modal de modif password
    $('#mtogglePasswordField').click(function(){
        var passwordField = $('#mpasswordField');
        var fieldType = passwordField.attr('type');

        if(fieldType === 'password') {
            passwordField.attr('type', 'text');
            $('#mtogglePasswordField').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            $('#mtogglePasswordField').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#mtogglePasswordField2').click(function(){
        var passwordField = $('#mpasswordField2');
        var fieldType = passwordField.attr('type');

        if(fieldType === 'password') {
            passwordField.attr('type', 'text');
            $('#mtogglePasswordField2').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            $('#mtogglePasswordField2').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#mtogglePasswordField3').click(function(){
        var passwordField = $('#mpasswordField3');
        var fieldType = passwordField.attr('type');

        if(fieldType === 'password') {
            passwordField.attr('type', 'text');
            $('#mtogglePasswordField3').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            $('#mtogglePasswordField3').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });


     //----- Initialisation des div et champ pour les models de couriers.
    //Div
    $('#partieAdverseDiv').attr('hidden', true);
    $('#appelDiv').attr('hidden', true);
    $('#dateProcesDiv').attr('hidden', true);
    $('#models').attr('hidden', true);

    $('#piece').removeAttr('hidden');
    $('#file').attr('required', true);

    //Champs
    $('#partieAdverse').removeAttr('required');
    $('#motif').removeAttr('required');
    $('#jugement').removeAttr('required');
    $('#courAppel').removeAttr('required');
    $('#dateProcesVerbal').removeAttr('required');

          

    const scrollableDiv = document.getElementById('scrollableDiv');
    let direction = 'bas'; // Initialise la direction du défilement vers le bas

    function faireDefiler() {
        const hauteurTotale = scrollableDiv.scrollHeight;
        const hauteurVisible = scrollableDiv.clientHeight;
        if (direction === 'bas') {
            if (scrollableDiv.scrollTop < hauteurTotale - hauteurVisible) {
            scrollableDiv.scrollTop += 200; // Fait défiler vers le bas
            } else {
            direction = 'haut'; // Change la direction vers le haut
            }
        } else if (direction === 'haut') {
            if (scrollableDiv.scrollTop > 0) {
            scrollableDiv.scrollTop -= 200; // Fait défiler vers le haut
            } else {
            direction = 'bas'; // Change la direction vers le bas
            }
        }
    }
    
    // Appel de la fonction faireDefiler toutes les 50 millisecondes pour simuler le défilement
    faireDefiler();

   

    $(".js') }}-example-tags").select2({
        tags: true,
        selectedIndex: true,
        tokenSeparators: [',', ' ']
    });

    $('.tacheSimpleDate').show();
    $('.tacheConditionnelDate').attr('hidden', true);
    $('.tacheSimpleClient').show();
    $('.tacheConditionnelClient').hide();

    //retirer les required
    document.getElementById('dateDebutTa').required = true;
    document.getElementById('dateDebutTa2').required = true;
    document.getElementById('dateFinTa').required = true;
    document.getElementById('dateFinTa2').required = true;
    document.getElementById('client').required = true;
    document.getElementById('affaireClient').required = true;


    document.getElementById('dateFinCond1').required = false;
    document.getElementById('dateFinCond2').required = false;



    //Mettre l'onglet tache client par defaut a la creation d'une tache
    //attribution de la valeur simple au champ
    $('.categorie').val('Simple');
    // Fonction permettant de verifier l'utilisateur
    function checkUsers() {
        // Les variables globales du programme
        const date = new Date().toLocaleString();

        const date1 = new Date().toLocaleTimeString();

        const date2 = new Date('07/10/2022 22:41:41').toLocaleTimeString()

        //console.log(` data ${date1} > ${date2}`);
        var userMail = $('#email').val();

        //console.log(` mail de l'utilisateur: ${userMail}`);

        $.ajax({
            type: "GET",
            url: `/check-user/${userMail}`,
            dataType: "json",
            success: function(response) {
                $.each(response.users, function(key, value) {

                    if (value.lastConnexion == null) {

                        localStorage.setItem('derniereConnexion', date);
                        updateConnexion(date);
                    } else {
                        localStorage.setItem('derniereConnexion', lastConnexion);
                        // Comparaison des dates pour la deconnexion de l'utilisateur
                    }
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
               // console.log('Erreur de connexion')
                //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
            }
        });
    }
});


/**
 * Fonction permettante d'enregistrer la derniere connexion
 *@param string data est la date de la dernière connexion
 **/
function updateConnexion(date) {
    $.ajax({
        type: "POST",
        url: `/check-users/${date}`,
        dataType: "json",
        success: function(response) {
            //console.log('Mise a jour effectuées avec success')
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('une erreur est survenue')
            //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
        }
    });

}
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {

     var monSwitchButtonLang = document.getElementById("infowitchLangInvoice");
          
          // FR/EN 
          $('#infowitchLangInvoice').on('change', function(e) {
              if (monSwitchButtonLang.checked) {
                  // Le switch button est fr
                  $('#labelFacture').text('FACTURE') ;
                  $('#labelDateInvoice').text('Fait le :') ;
                  $('#labelDateEcheance').text('Date d\'écheance :');
                  $('#labelClient').text('CLIENT') ;
                  $('#labelDescription').text('DESCRIPTIONS & DETAILS :');
                  $('#labelDesignation').text('Designation');
                  $('#labelPrix').text('Prix');
                  $('#labelTotalHt').text('Total HT');
                  $('#labelTotalTva').text('Taxes (TVA)');
                  $('#labelTotalApayer').text('Total à payer (TTC)');
                  $('#labelHistory').text(' Historique de paiement');
                  $('#labelDatePaiement').text('Date de paiement');
                  $('#labelMontantPayer').text('Montant payé') ;
                  $('#labelMontantRestant').text('Montant restant') ;
                  $('#labelMethode').text('Methode de paiement') ;
                  $('#labelSolde').text('Solde restant à payer') ;
                  $('#labelTTC').text('Total à payer (TTC)') ;
                  $('#labelReferenceB').text(' References bancaires') ;
                  $('#labelTerme').text('Termes & Conditions') ;

                  $('.methodePaiemet').each(function() {

                    var method = $(this).text();

                        if (method==='Cash') {
                            $(this).text('Espèce');
                        }
                        if (method==='Check') {
                            $(this).text('Chèque');
                        }
                        if (method==='Wire') {
                            $(this).text('Virement bancaire');
                        }
                    });

                 
              } else {
                  // Le switch button est en
                  $('#labelFacture').text('INVOICE') ;
                  $('#labelDateInvoice').text('Date :') ;
                  $('#labelDateEcheance').text('Due date :') ;
                  $('#labelClient').text('CLIENT') ;
                  $('#labelDescription').text('DESCRIPTIONS & DETAILS :') ;
                  $('#labelDesignation').text('Designation') ;
                  $('#labelPrix').text('Price') ;
                  $('#labelTotalHt').text('Total WT') ;
                  $('#labelTotalTva').text('Taxes (VAT)') ;
                  $('#labelTotalApayer').text('Total amount (TTC)') ;
                  $('#labelHistory').text(' Payment history') ;
                  $('#labelDatePaiement').text('Payment date') ;
                  $('#labelMontantPayer').text('Paid') ;
                  $('#labelMontantRestant').text('Remaining balance') ;
                  $('#labelMethode').text('Method of payment') ;
                  $('#labelSolde').text('Remaining balance') ;
                  $('#labelTTC').text('Total to pay (including tax)') ;
                  $('#labelReferenceB').text(' Bank references') ;
                  $('#labelTerme').text('Termes & Conditions') ;

                  $('.methodePaiemet').each(function() {

                    var method = $(this).text();

                        if (method==='Espèce') {
                            $(this).text('Cash');
                        }
                        if (method==='Chèque') {
                            $(this).text('Check');
                        }
                        if (method==='Virement bancaire') {
                            $(this).text('Wire');
                        }
                    });
                  
              }
          });


});
// Script permettant de chercher les informations du personnels dans la base de données
$(document).ready(function() {

   

    console.warn = () => {};

    $('#styleOptions').styleSwitcher();

    $('#matriculeInfo').attr('hidden', true);
    $('#trueUser').attr('hidden', true);
    let matriculeValue = document.getElementById("getMatricule");
    // L'evenement de vérification des matricules
    // ASK-B1A7
    matriculeValue.addEventListener('keydown', function(e) {

        if (e.target.value == '') {
            $('#matriculeInfo').attr('hidden', true);
            $('#trueUser').attr('hidden', true);
        }
        // Affichage du message d'information pour la recherche de l'utilisateur
        if (e.target.value !== '') {

            $('#matriculeInfo').removeAttr('hidden');
            $('#matriculeInfo').css('color', 'red');
            $.ajax({
                type: "GET",
                url: `{{ route('getMatricule') }}`,
                dataType: "json",
                success: function(resp) {
                    //console.log(resp)
                    $.each(resp.matricule, function(key, value) {

                        if (value.matricules === e.target.value) {
                            $('#matriculeInfo').attr('hidden', true);
                            $('#trueUser').removeAttr('hidden');
                            e.preventDefault()
                        } else {
                            $('#trueUser').attr('hidden', true);
                            $('#matriculeInfo').removeAttr('hidden');
                        }
                    })
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
                }
            });
        }
    });
});
</script>

<script>
/**
 *Script permettant de lire les fichiers
 *@param string file
 *@param string type
 **/
function readFile(file) {

    //alert(`Le chemin du fichier est : ${path} et le type est ${type}`)

    var reader = $('#reader');
    var options = {
        height: '100%',
        width: '100%',
        page: '1',
        pdfOpenParams: {
            pagemode: "thumbs",
            navpanes: 0,
            toolbar: 0,
            statusbar: 0,
            view: "FitV"
        }
    };

    PDFObject.embed(`{{URL::to('/')}}/${file}`, reader, options);


}
</script>
<script>
// Les script spécifique pour l'application
$(document).ready(function() {
    console.warn = () => {};

    $('#radioStacked1').click();


    $('.tacheConditionnelClient').hide();
    // Mettre les champ priorite cacher a Faible
    $('.priorite').val('Faible');


    //activer personne physique au demarrage
    $('#typeAdverse1').click();


    if ($('#roleAdverse2').is(':checked') == false) {
        $('#roleAdverse1').removeAttr('checked');
        $('#other').attr('hidden', true);

        $('#roleAdverse').val('Defendeur');
    } else if ($('#roleAdverse2').is(':checked') == true) {
        $('#roleAdverse1').removeAttr('checked');
        $('#roleAdverse2').attr('checked', true);
        $('#other').attr('hidden', true);
        $('#roleAdverse').val('Defendeur');
    }

    //demarrage de la recherche de notifications
    newNotification()
    // Script pour le traitement des formulaires du client
    // ajout des proprietes permettant de masquer les deux formulaires
    $('#clientMoral').attr('hidden', true);
    $('#clientPhysique').attr('hidden', true);

    $('#typeEntreprise').on("change", function() {
        var val = $(this).val();

        if (val == "client physique") {
            $('#clientMoral').attr('hidden', true);
            $('#clientPhysique').removeAttr('hidden');
            $('#clientMoral')[0].reset();

        } else if (val == "client moral") {
            $('#clientPhysique').attr('hidden', true);
            $('#clientMoral').removeAttr('hidden');
            $('#clientPhysique')[0].reset();
        } else {
            $('#clientPhysique').attr('hidden', true);
            $('#clientMoral').attr('hidden', true);
            $('#clientPhysique')[0].reset();
            $('#clientMoral')[0].reset();
        }
    });

    $('#clientSelect').attr('hidden', true);

    $('#radioStacked1').on('click', function() {
        if ($('#radioStacked1').is(':checked') == true) {
            $('#clientSelect').attr('hidden', true);
            $('#affaireContent').attr('hidden', true);
            $('#radioStacked1').val("Cabinet");
            $('#identifiant').empty();
            $('#identifiant').val("");
            $('#affaireClient').val("");
            $('#client').val("");
            $('#affaireClient').removeAttr('required');
            $('#client').removeAttr('required');

            var index = -1;
            var select = $('.select');
            var select2 = $('.select2');

            select.val(index);
            select2.val(index).trigger('change.select2');
        }
    });
    $('#radioStacked2').on('click', function() {
        if ($('#radioStacked2').is(':checked') == true) {
            $('#clientSelect').removeAttr('hidden');
            $('#affaireContent').removeAttr('hidden');
            $('#affaireClient').val("");
            $('#client').val("");
            $('#affaireClient').attr('required', true);
            $('#client').attr('required', true);
            $('#radioStacked1').val("");

            var index = -1;
            var select = $('.select');
            var select2 = $('.select2');

            select.val(index);
            select2.val(index).trigger('change.select2');
        }
    });


    $('#radioStackedPro1').on('click', function() {
        if ($('#radioStackedPro1').is(':checked') == true) { 
            // Actions
        }
    });

    $('#radioStackedPro2').on('click', function() {
        if ($('#radioStackedPro2').is(':checked') == true) {
           // Actions
        }
    });

    $('#selectTypeProcedure').on("change", function() {

        var selectTypeProcedure = $('#selectTypeProcedure').val();

        if (selectTypeProcedure == 'contentieux') {
            $('#divTypeRequete').attr('hidden', true);
            $('#orientationProcedurale').removeAttr('hidden');
            $('#divNiveauProcedural').removeAttr('hidden');
            $('#radioStackedPro1').attr('required', true); 

            $('#radioStackedPro1').val("Fond");
            $('#radioStackedPro2').val("");

            var monDiv = document.getElementById("audienceFormContent");
            monDiv.innerHTML = "";

        }
        if (selectTypeProcedure == 'requete') {
            $('#divTypeRequete').removeAttr('hidden');
            $('#divNiveauProcedural').attr('hidden', true); radioStackedPro1
            $('#orientationProcedurale').attr('hidden', true); 
            $('#radioStackedPro1').removeAttr('required'); 
            $('#radioStackedPro2').val("Référé");
            $('#radioStackedPro1').val("");


            var xhr = new XMLHttpRequest();

            xhr.onload = function() {
                if (xhr.status === 200) {
                    var contenuPage = xhr.responseText;

                    var monDiv = document.getElementById("audienceFormContent");
                    monDiv.innerHTML = "";
                    monDiv.innerHTML = contenuPage;
                }
            };

            xhr.open("GET", "/requeteForm", true);
            xhr.send();

            $('#formInstruction').removeAttr('hidden');

                    
        }

    });

    $('#typeRequete').on("change", function() {

        var selectTypeRequete = $('#typeRequete').val();

        if (selectTypeRequete == 'Requête aux fins d\'injonction de payer') {
            $('#divRequerent').removeAttr('hidden');
            $('.mentionsInjonctionPayer').removeAttr('hidden');

            $('.mentionsInjonctionRestituer').attr('hidden', true);
            $('.mentionsInjonctionFaire').attr('hidden', true);
          

        }
        else if (selectTypeRequete == 'Requête aux fins d\'injonction de restituer ou de délivrer') {
            $('#divRequerent').removeAttr('hidden');
            $('.mentionsInjonctionRestituer').removeAttr('hidden');

            $('.mentionsInjonctionPayer').attr('hidden', true);
            $('.mentionsInjonctionFaire').attr('hidden', true);

        }
        else if (selectTypeRequete == 'Requête aux fins d\'injonction de faire') {
            $('#divRequerent').removeAttr('hidden');
            $('.mentionsInjonctionFaire').removeAttr('hidden');

            $('.mentionsInjonctionPayer').attr('hidden', true);
            $('.mentionsInjonctionRestituer').attr('hidden', true);
        }
        else{
            $('#divRequerent').attr('hidden', true);
            $('.mentionsInjonctionFaire').attr('hidden', true);

            $('.mentionsInjonctionPayer').attr('hidden', true);
            $('.mentionsInjonctionRestituer').attr('hidden', true);
        }

    });

    
    // traitement du formulaire d'enregistrement d'une audience
    // l'action sur les buttons radio lors du lancement de l'application
    // $('#adversePersonne0').attr('hidden', false);
    // $('#adverseEntreprise0').attr('hidden', true);


    $('#typeAdverse2').on('click', function() {
        $('#adversePersonne').attr('hidden', true);
        $('#adverseEntreprise').removeAttr('hidden');

        $('#prenom').removeAttr('required');
        $('#nom').removeAttr('required');
        $('#profession').removeAttr('required');
        $('#nationalite').removeAttr('required');
        $('#dateNaissance').removeAttr('required');
        $('#lNaissance').removeAttr('required');
        $('#pays').removeAttr('required');
        $('#domicil').removeAttr('required');

        $('#prenom').val('');
        $('#nom').val('');
        $('#profession').val('');
        $('#nationalite').val('');
        $('#dateNaissance').val('');
        $('#lNaissance').val('');
        $('#pays').val('');
        $('#domicil').val('');
    });
    // Script du traitement sur la selection client pour recuperer son affaires
    function fechAffaireClient(idClient) {

        $('#affaireContent').removeAttr('hidden');
        $.ajax({
            type: "GET",
            url: `/fetch-affaire/${idClient}`,
            dataType: "json",
            success: function(response) {
                $('#affaireClient').html("");
                $('#affaireClient').append(
                    `<option selected value='' disabled>-- Choisissez --</option>`);

                //console.log(response);
                $.each(response.affaire, function(key, value) {
                    $('#affaireClient').append(
                        `<option value=${value.idAffaire}> ${value.nomAffaire}</option>`
                    )
                });

                // pour la page creation de courier depart
                $.each(response.client, function(key, value) {
                    if (value.adresse == null) {
                        $('.adresseClientSpan').text(`${value.adresseEntreprise}`);
                    } else {
                        $('.adresseClientSpan').text(`${value.adresse}`);
                    }

                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
               // console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
            }
        });
    }



    function getInitial(idPersonnel) {

        const date = new Date().getFullYear();
        $.ajax({
            type: "GET",
            url: `/initQersy/${idPersonnel}`,
            dataType: "json",
            success: function(response) {

                $.each(response.initial, function(key, value) {
                    //console.log(value.initialPersonnel)
                    //$idCourier = 'N°'.$id.'/AD/ASK/'.date('Y');
                    //alert(value.initialPersonnel)
                    $('.initialPersonnel').text(`${value.initialPersonnel}`);
                    //$('#codeCourier').text(`${value.initialPersonnel}`)
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
            }
        });
    }

    function getInitialAdmin(idAdmin) {

        const date = new Date().getFullYear();
        $.ajax({
            type: "GET",
            url: `/initAdmin/${idAdmin}`,
            dataType: "json",
            success: function(response) {

                $.each(response.initialAdmin, function(key, value) {
                    //console.log(value.initial)
                    //$idCourier = 'N°'.$id.'/AD/ASK/'.date('Y');
                    //alert(value.initialPersonnel)
                    $('.initialAdmin').text(`${value.initial}/${date}`);
                    $('#signataire').val(value.initial);
                    $('.nomAdmin').text(`${value.name}`);
                    //$('#codeCourier').text(`${value.initialPersonnel}`)
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
               //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
            }
        });
    }


    $('#client').on('change', function() {

        fechAffaireClient($(this).val());
        var idClient = $(this).val();
        titre = document.getElementById("client").options[document
            .getElementById('client').selectedIndex].text;
        $('.clientSpan').text(`${titre}`);

        $.ajax({
            type: "GET",
            url: `/info-client/${idClient}`,
            dataType: "json",
            success: function(response) {

                $.each(response.client, function(key, value) {
                    $('.rccm').text(`${value.rccm}`);

                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
            }
        });
    });

    $('#preparant').on('change', function(e) {
        getInitial(e.target.value);
    });

    $('#admin').on('change', function(e) {
        getInitialAdmin(e.target.value);
    });
    // Script permettant d'afficher le reste des informations de l'audiences
    $('#up').attr('hidden', true);
   //$('#audienceInfos').attr('hidden', true);
    $('#fileAssignAudience').attr('hidden', true);
    $('#idAudienceAssign').attr('hidden', true);

    $('#down').on('click', function() {
        $('#audienceInfos').removeAttr('hidden');
        $('#up').removeAttr('hidden');
        $('#down').attr('hidden', true);
    });
    $('#up').on('click', function() {
        $('#up').attr('hidden', true);
        $('#audienceInfos').attr('hidden', true);
        $('#down').removeAttr('hidden');
    });

    // Script permettant d'afficher le reste des informations du traitement de taches
    $('#uptraitement').attr('hidden', true);
    $('#traitement').attr('hidden', true);


    $('#downtraitement').on('click', function() {
        $('#traitement').removeAttr('hidden');
        $('#uptraitement').removeAttr('hidden');
        $('#downtraitement').attr('hidden', true);
    });
    $('#uptraitement').on('click', function() {
        $('#uptraitement').attr('hidden', true);
        $('#traitement').attr('hidden', true);
        $('#downtraitement').removeAttr('hidden');
    });

    $('#prioriteSelect').on('change', function(e) {
        $('.priorite').val(e.target.value);

    });



    // Script permettante de gerer les taches conditionnelles et successives

    function getTache() {
        $.ajax({
            type: "GET",
            url: `/taches/task`,
            dataType: "json",
            success: function(response) {
                $.each(response.taches, function(key, value) {
                    $('#idTacheParente').append(`
                         <option value="" selected disabled>-- Choisissez --</option>
                        <option id="${value.titre}" value="${value.slug}">${value.titre}</option>
                    `)

                });

                $('#idTacheParente').on('change', function(e) {
                    $('.parenteTache').val(e.target.value);

                    titre = document.getElementById("idTacheParente").options[document
                        .getElementById('idTacheParente').selectedIndex].text;
                    slugTache = $('#idTacheParente').val();
                    $('.clientCond').html('');
                    $('.idAffaireCond').html('');
                    getClientAffaire(slugTache, titre);

                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
               // console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
            }
        });
    }

    function getClientAffaire(slugTache, titre) {
        $.ajax({
            type: "GET",
            url: `/tache/clientAffaire/${slugTache}/${titre}`,
            dataType: "json",
            success: function(response) {
                if (response.client == '') {

                    $('.clientCond').append(`
                       
                       <option value="Cabinet">Cabinet</option>
                   `)

                    $('.idAffaireCond').append(`
                       
                       <option value="Cabinet">Cabinet</option>
                   `)

                } else {
                    $.each(response.client, function(key, value) {

                        if (value.denomination) {

                            $('.clientCond').append(
                                `<option value="${value.idClient}">${value.denomination} </option>`
                            )

                        } else {

                            $('.clientCond').append(
                                `<option value="${value.idClient}">${value.prenom} ${value.nom} </option>`
                            )

                        }

                    });
                }

                $.each(response.affaire, function(key, value) {
                    $('.idAffaireCond').append(`
                       
                        <option value="${value.idAffaire}">${value.nomAffaire}</option>
                    `)
                });

            },
            error: function(jqXHR, textStatus, errorThrown) {
               // console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
            }
        });
    }

    function tacheSimpleConditionnel() {
        $('.tacheSimpleDate').hide();
        $('.tacheConditionnelDate').removeAttr('hidden');
        $('.tacheSimpleClient').hide();
        $('.tacheConditionnelClient').show();


        $('#typeTache').val(1);

        var selectElement = document.getElementById("typeTache");



        //retirer les required
        document.getElementById('dateDebutTa').required = false;
        document.getElementById('dateDebutTa2').required = false;
        document.getElementById('dateFinTa').required = false;
        document.getElementById('dateFinTa2').required = false;
        document.getElementById('client').required = false;
        document.getElementById('affaireClient').required = false;

        document.getElementById('dateFinCond1').required = true;
        document.getElementById('dateFinCond2').required = true;


    }

    function tacheSimpleConditionnelReverse() {

        $('.tacheSimpleDate').show();
        $('.tacheConditionnelDate').attr('hidden', true);
        $('.tacheSimpleClient').show();
        $('.tacheConditionnelClient').hide();

        $('#typeTache').val(1);
        var selectElement = document.getElementById("typeTache");
        selectElement.disabled = false;


        //retirer les required
        document.getElementById('dateDebutTa').required = true;
        document.getElementById('dateDebutTa2').required = true;
        document.getElementById('dateFinTa').required = true;
        document.getElementById('dateFinTa2').required = true;
        document.getElementById('client').required = true;
        document.getElementById('affaireClient').required = true;


        document.getElementById('dateFinCond1').required = false;
        document.getElementById('dateFinCond2').required = false;

    }


    $('#rowParente').attr('hidden', true);

    $('#tacheSimple').on('click', function() {
        $('.categorie').val('Simple');
        $('#rowParente').attr('hidden', true);
        $('#idTacheParente').removeAttr('required');
     
        tacheSimpleConditionnelReverse();
    });

    $('#tacheConditionnelle').on('click', function() {
        $('.categorie').val('Conditionnelle');
        $('#rowParente').removeAttr('hidden');
        $('#idTacheParente').attr('required', true);
      
        $('#tacheEntreprise').attr('hidden', true);
        $('#descOrdinaire').removeAttr('hidden');


        getTache();
        tacheSimpleConditionnel();
    });

    // Les scripts pour le control des dates pour l'enregistrement d'une tâche

    // Les variables de date
    let firstDate = $('.dateDebutTa');
    let secondDate = $('.dateFinTa');

    // Les variables du message
    let fistMessage = $('.m1');
    let secondMessage = $('.m2');

    // Les variables contenant des valeurs
    let dateValue1 = ''
    let dateValue2 = '';

    // control du bouton d'enregistrement
    let enregistrer = $('#addTache');

    firstDate.on('change', (e) => {
        dateValue1 = e.target.value;
        if (dateValue2 !== '') {
            if (dateValue2 < dateValue1) {
                enregistrer.attr('hidden', true);
                fistMessage.text(
                    `la deuxième dates : ${dateValue2} est inférieur à la première date : ${dateValue1}`
                );
                //alert(`la deuxième dates : ${dateValue2} est inférieur à la première date : ${dateValue1}`) ;
            } else {
                enregistrer.removeAttr('hidden');

            }
        }
    });
    secondDate.on('change', (e) => {
        dateValue2 = e.target.value;
        if (dateValue1 !== '') {
            if (dateValue1 > dateValue2) {
                enregistrer.attr('hidden', true);
                secondMessage.text(
                    `la première date : ${dateValue1} est supperieur à la deuxième dates : ${dateValue2}`
                );
                //alert(`la première date : ${dateValue1} est supperieur à la deuxième dates : ${dateValue2}`) ;
            } else {
                enregistrer.removeAttr('hidden');

            }
        }
    });

    // Script du control de la date de la prochaine audience
    $('#NA').on('click', function(e) {
        if ($('#NA').is(':checked') == true) {
            $('#PDate').attr('readonly', true);
            $('#PDate').attr('hidden', true);
            $('#PDate').attr('type', 'text');
            $('#PDate').removeAttr('required');
            $('#PDate').val('N/A');
        } else {
            $('#PDate').removeAttr('readonly');
            $('#PDate').removeAttr('hidden');
            $('#PDate').attr('required', true);
            $('#PDate').attr('type', 'date');
            $('#PDate').val('');
        }
    });
});

function newNotification() {

    $.ajax({
        type: "GET",
        url: `/fetch-notif`,
        dataType: "json",
        success: function(response) {
            var nbre = response.newNotif.length;
            var bips = response.bips.length;
            $.each(response.bips, function(key, value) {
                playsound();
            });
            //console.log(bips);

            $('#totalNotif').append(
                `<span class="cl-white theme-bg a-nav__link-badge a-badge ">${nbre}</span>`
            )

        },
        error: function(jqXHR, textStatus, errorThrown) {
            //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
        }
    });


    document.getElementById('totalNotif').innerHTML = '';
    setTimeout(function() {
        newNotification()
    }, 5000);

}

/*

function newNotificationListe() {


    document.getElementById('notification-box').innerHTML = '';
    document.getElementById('nbNotif').innerHTML = '';

    $.ajax({
        type: "GET",
        url: `/fetch-notif`,
        dataType: "json",
        success: function(response) {


            var nbre = response.newNotif.length;

            $.each(response.newNotif, function(key, value) {
                var slug = value.urlParam;
                var category = value.categorie;
                if (category == 'Tâche') {
                    $('#notification-box').append(
                        ` <div class="ground ground-list-single">
              <div class="btn-circle-40 btn-info">
              <i class="ti ti-layers"></i>
              </div>
            <div class="ground-content">
            <a href="/tache/view/${value.urlParam}" id="${value.urlParam}" class="${value.id}"  onclick=" var param=this.id ; var idNotif=this.className; voir(param,idNotif)"><h5><b>${value.categorie}</b></h5></a>
            <small class="text-fade">${value.messages}</small>
            </div></div>`
                    )
                } else if (category == 'Courriers - Départ') {
                    $('#notification-box').append(
                        ` <div class="ground ground-list-single">
              <div class="btn-circle-40 btn-info">
              <i class="fa fa-envelope"></i>
              </div>
            <div class="ground-content">
            <a href="/courier_depart/viewFonction/${value.urlParam}" id="${value.urlParam}" class="${value.id}"  onclick=" var param=this.id ; var idNotif=this.className; voir(param,idNotif)"><h5><b>${value.categorie}</b></h5></a>
            <small class="text-fade">${value.messages}</small>
            </div></div>`
                    )

                } else if (category == 'Courriers - Arrivée') {
                    $('#notification-box').append(
                        ` <div class="ground ground-list-single">
              <div class="btn-circle-40 btn-info">
              <i class="fa fa-envelope"></i>
              </div>
            <div class="ground-content">
            <a href="/courier_arriver/view/${value.urlParam}" id="${value.urlParam}" class="${value.id}"  onclick=" var param=this.id ; var idNotif=this.className; voir(param,idNotif)"><h5><b>${value.categorie}</b></h5></a>
            <small class="text-fade">${value.messages}</small>
            </div></div>`
                    )

                } else if (category == 'Rappel Courrier') {
                    $('#notification-box').append(
                        ` <div class="ground ground-list-single">
              <div class="btn-circle-40 btn-warning">
              <i class="fa fa-bullhorn"></i>
              </div>
            <div class="ground-content">
            <a href="/courier_arriver/view/${value.urlParam}" id="${value.urlParam}" class="${value.id}"  onclick=" var param=this.id ; var idNotif=this.className; voir(param,idNotif)"><h5><b>${value.categorie}</b></h5></a>
            <small class="text-fade">${value.messages}</small>
            </div></div>`
                    )



                }

            });

            $.each(response.newNotifSuivi, function(key, value) {


                $('#notification-box').append(
                    ` <div class="ground ground-list-single">
              <div class="btn-circle-40 btn-info">
              <i class="fa fa-balance-scale"></i>
              </div>
            <div class="ground-content">
            <a href="/audience/view/${value.idAudience}/${value.slug}/${value.niveauProcedural}" id="${value.urlParam}" class="${value.id}"  onclick=" var param=this.id ; var idNotif=this.className; voir(param,idNotif)"><h5><b>${value.categorie}</b></h5></a>
            <small class="text-fade">${value.messages}</small>
            </div></div>`
                )


            });



            $.each(response.newNotifAudience, function(key, value) {
                $('#notification-box').append(
                    ` <div class="ground ground-list-single">
             <div class="btn-circle-40 btn-info">
             <i class="fa fa-balance-scale"></i>
             </div>
           <div class="ground-content">
           <a href="/audience/view/${value.idAudience}/${value.slug}/${value.niveauProcedural}" id="${value.urlParam}" class="${value.id}"  onclick=" var param=this.id ; var idNotif=this.className; voir(param,idNotif)"><h5><b>${value.categorie}</b></h5></a>
           <small class="text-fade">${value.messages}</small>
           </div></div>`
                )


            });

            $.each(response.newNotifSuiviAppel, function(key, value) {
                $('#notification-box').append(
                    ` <div class="ground ground-list-single">
             <div class="btn-circle-40 btn-info">
             <i class="fa fa-balance-scale"></i>
             </div>
           <div class="ground-content">
           <a href="/audience/view/${value.idAudience}/${value.slug}/${value.niveauProcedural}" id="${value.urlParam}" class="${value.id}"  onclick=" var param=this.id ; var idNotif=this.className; voir(param,idNotif)"><h5><b>${value.categorie}</b></h5></a>
           <small class="text-fade">${value.messages}</small>
           </div></div>`
                )


            });

            $.each(response.newNotifRequeteSuivi, function(key, value) {
                $('#notification-box').append(
                    ` <div class="ground ground-list-single">
             <div class="btn-circle-40 btn-info">
             <i class="fa fa-balance-scale"></i>
             </div>
           <div class="ground-content">
           <a href="/requete/detail/${value.slug}" id="${value.urlParam}" class="${value.id}"  onclick=" var param=this.id ; var idNotif=this.className; voir(param,idNotif)"><h5><b>${value.categorie}</b></h5></a>
           <small class="text-fade">${value.messages}</small>
           </div></div>`
                )
            });

            $.each(response.newNotifRequete, function(key, value) {
                $('#notification-box').append(
                    ` <div class="ground ground-list-single">
             <div class="btn-circle-40 btn-info">
             <i class="fa fa-balance-scale"></i>
             </div>
           <div class="ground-content">
           <a href="/requete/detail/${value.slug}" id="${value.urlParam}" class="${value.id}"  onclick=" var param=this.id ; var idNotif=this.className; voir(param,idNotif)"><h5><b>${value.categorie}</b></h5></a>
           <small class="text-fade">${value.messages}</small>
           </div></div>`
                )
            })

           // consol.log();

            $.each(response.newNotifsFacture, function(key, value) {
                $('#notification-box').append(
                    ` <div class="ground ground-list-single">
             <div class="btn-circle-40 btn-info">
             <i class="fa fa-money"></i>
             </div>
           <div class="ground-content">
           <a href="/facturation/show/${value.slug}" id="${value.urlParam}" class="${value.id}"  onclick=" var param=this.id ; var idNotif=this.className; voir(param,idNotif)"><h5><b>${value.categorie}</b></h5></a>
           <small class="text-fade">${value.messages}</small>
           </div></div>`
                )


            });

            $('#nbNotif').append(
                `<span class="a-dropdown--title" >${nbre} Notification(s)</span>`)



        },
        error: function(jqXHR, textStatus, errorThrown) {
            //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
        }
    });


}
*/

function newNotificationListe() {


    document.getElementById('notification-box').innerHTML = '';
    document.getElementById('nbNotif').innerHTML = '';

    $.ajax({
        type: "GET",
        url: `/fetch-notif`,
        dataType: "json",
        success: function(response) {


            var nbre = response.newNotif.length;

            
            $.each(response.newNotif, function(key, value) {
                var slug = value.urlParam;
                var category = value.categorie;
              

            });

             $.each(response.notifSuivitAudience, function(key, value) {

                
                  // Construire le contenu du h5
                  let h5Text = ` ${value.idClient || ''} > ${value.prenom || ''} ${value.nom || ''} ${value.denomination || ''}> ${value.idAffaire || ''}  ${value.nomAffaire || ''}`;

                // Tronquer h5 si plus de 27 caractères
                if (h5Text.length > 30) {
                    h5Text = h5Text.substring(0, 30) + '...';
                }

                    // Tronquer le message aussi (au cas où il serait long)
                    let message = value.messages.length > 27
                    ? value.messages.substring(0, 27) + '...'
                    : value.messages;

                $('#notification-box').append(
                    ` <div class="ground ground-list-single">
                    <div class="btn-circle-40 btn-info">
                    <i class="fa fa-balance-scale"></i>
                    </div>
                    <div class="ground-content">
                    <a href="/audience/view/${value.idAudience}/${value.slug}/${value.niveauProcedural}" id="${value.urlParam}" class="${value.id}"  onclick=" var param=this.id ; var idNotif=this.className; voir(param,idNotif)"><h5><b>  ${h5Text}</b></h5></a>
                    <small class="text-fade">${value.messages}</small>
                    </div></div>`
                 )
            });


           

            $.each(response.newNotifsCourierArriversCabinet, function(key, value) {
                $('#notification-box').append(`
                    <div class="ground ground-list-single">
                        <div class="btn-circle-40 btn-info">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="ground-content">
                            <a href="/courier_arriver/view/${value.urlParam}" 
                            id="${value.urlParam}" 
                            class="${value.id}"  
                            onclick="var param=this.id; var idNotif=this.className; voir(param,idNotif)">
                                <h5><b>${value.categorie} <small class="label bg-primary">Cabinet</small></b></h5>
                            </a>
                            <small class="text-fade">${value.messages}</small>
                        </div>
                    </div>
                `);
            });

            $.each(response.newNotifsCourierArriversClient, function(key, value) {

                 // Construire le contenu du h5
                 let h5Text = `${value.idClient || ''} > ${value.prenom || ''} ${value.nom || ''} ${value.denomination || ''}> ${value.idAffaire || ''}  ${value.nomAffaire || ''}`;

                    // Tronquer h5 si plus de 27 caractères
                    if (h5Text.length > 30) {
                        h5Text = h5Text.substring(0, 30) + '...';
                    }
                        // Tronquer le message aussi (au cas où il serait long)
                let message = value.messages.length > 27
                    ? value.messages.substring(0, 27) + '...'
                    : value.messages;

                $('#notification-box').append(`
                    <div class="ground ground-list-single">
                        <div class="btn-circle-40 btn-info">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="ground-content">
                            <a href="/courier_arriver/view/${value.urlParam}" 
                            id="${value.urlParam}" 
                            class="${value.id}"  
                            onclick="var param=this.id; var idNotif=this.className; voir(param,idNotif)">
                                <h5><b>${h5Text} </b></h5>
                            </a>
                            <small class="text-fade">${value.messages}</small>
                        </div>
                    </div>
                `);
            });

            $.each(response.newNotifsCourierDepartsCabinet, function(key, value) {
                
                $('#notification-box').append(`
                    <div class="ground ground-list-single">
                        <div class="btn-circle-40 btn-info">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="ground-content">
                            <a href="/courier_depart/viewFonction/${value.urlParam}"
                            id="${value.urlParam}" 
                            class="${value.id}"  
                            onclick="var param=this.id; var idNotif=this.className; voir(param,idNotif)">
                                <h5><b>${value.categorie} <small class="label bg-primary">Cabinet</small></b></h5>
                            </a>
                            <small class="text-fade">${value.messages}</small>
                        </div>
                    </div>
                `);
            });

            $.each(response.newNotifsCourierDepartsClient, function(key, value) {
                 // Construire le contenu du h5
                 let h5Text = `${value.idClient || ''} > ${value.prenom || ''} ${value.nom || ''} ${value.denomination || ''} > ${value.idAffaire || ''}  ${value.nomAffaire || ''}`;

                    // Tronquer h5 si plus de 27 caractères
                    if (h5Text.length > 30) {
                        h5Text = h5Text.substring(0, 30) + '...';
                    }
                        // Tronquer le message aussi (au cas où il serait long)
                let message = value.messages.length > 27
                    ? value.messages.substring(0, 27) + '...'
                    : value.messages;
                $('#notification-box').append(`
                    <div class="ground ground-list-single">
                        <div class="btn-circle-40 btn-info">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="ground-content">
                            <a href="/courier_depart/viewFonction/${value.urlParam}" 
                            id="${value.urlParam}" 
                            class="${value.id}"  
                            onclick="var param=this.id; var idNotif=this.className; voir(param,idNotif)">
                                <h5><b>${h5Text} </b></h5>
                            </a>
                            <small class="text-fade">${value.messages}</small>
                        </div>
                    </div>
                `);
            });

            $.each(response.newNotifsTaches, function(key, value) {
                 // Construire le contenu du h5
                 let h5Text = `${value.idClient || ''} > ${value.prenom || ''} ${value.nom || ''} ${value.denomination || ''}> ${value.idAffaire || ''}  ${value.nomAffaire || ''}`;

                    // Tronquer h5 si plus de 27 caractères
                    if (h5Text.length > 30) {
                        h5Text = h5Text.substring(0, 30) + '...';
                    }
                        // Tronquer le message aussi (au cas où il serait long)
                let message = value.messages.length > 27
                    ? value.messages.substring(0, 27) + '...'
                    : value.messages;

                $('#notification-box').append(
                        ` <div class="ground ground-list-single">
                <div class="btn-circle-40 btn-info">
                <i class="ti ti-layers"></i>
                </div>
                <div class="ground-content">
                <a href="/tache/view/${value.urlParam}" id="${value.urlParam}" class="${value.id}"  onclick=" var param=this.id ; var idNotif=this.className; voir(param,idNotif)"><h5><b>${h5Text} </b></h5></a>
                <small class="text-fade">${value.messages}</small>
                </div></div>`
                    )
                });

            $.each(response.newNotifSuivi, function(key, value) {

                  // Construire le contenu du h5
                  let h5Text = ` ${value.idClient || ''} > ${value.prenom || ''} ${value.nom || ''} ${value.denomination || ''}> ${value.idAffaire || ''}  ${value.nomAffaire || ''}`;

                // Tronquer h5 si plus de 27 caractères
                if (h5Text.length > 30) {
                    h5Text = h5Text.substring(0, 30) + '...';
                }

                    // Tronquer le message aussi (au cas où il serait long)
                    let message = value.messages.length > 27
                    ? value.messages.substring(0, 27) + '...'
                    : value.messages;

                $('#notification-box').append(
                    ` <div class="ground ground-list-single">
                    <div class="btn-circle-40 btn-info">
                    <i class="fa fa-balance-scale"></i>
                    </div>
                        <div class="ground-content">
                        <a href="/audience/view/${value.idAudience}/${value.slug}/${value.niveauProcedural}" id="${value.urlParam}" class="${value.id}"  onclick=" var param=this.id ; var idNotif=this.className; voir(param,idNotif)"><h5><b>  ${h5Text}</b></h5></a>
                        <small class="text-fade">${value.messages}</small>
                        </div></div>`
                 )
            });



            $.each(response.newNotifAudience, function(key, value) {

                  // Construire le contenu du h5
                  let h5Text = `${value.idClient || ''} > ${value.prenom || ''} ${value.nom || ''} ${value.denomination || ''}> ${value.idAffaire || ''}  ${value.nomAffaire || ''}`;

                // Tronquer h5 si plus de 27 caractères
                if (h5Text.length > 30) {
                    h5Text = h5Text.substring(0, 30) + '...';
                }
                    // Tronquer le message aussi (au cas où il serait long)
                    let message = value.messages.length > 27
                    ? value.messages.substring(0, 27) + '...'
                    : value.messages;
                $('#notification-box').append(
                    ` <div class="ground ground-list-single">
                    <div class="btn-circle-40 btn-info">
                    <i class="fa fa-balance-scale"></i>
                    </div>
                <div class="ground-content">
                <a href="/audience/view/${value.idAudience}/${value.slug}/${value.niveauProcedural}" id="${value.urlParam}" class="${value.id}"  onclick=" var param=this.id ; var idNotif=this.className; voir(param,idNotif)"><h5><b> ${h5Text}</b></h5></a>
                <small class="text-fade">${value.messages}</small>
                </div></div>`
                )

                console.log(response.newNotifAudience);

                


            });

            $.each(response.newNotifAudience2, function(key, value) {

                 // Construire le contenu du h5
                 let h5Text = `${value.idClient || ''} > ${value.prenom || ''} ${value.nom || ''} ${value.denomination || ''}> ${value.idAffaire || ''}  ${value.nomAffaire || ''}`;

                // Tronquer h5 si plus de 27 caractères
                if (h5Text.length > 30) {
                    h5Text = h5Text.substring(0, 30) + '...';
                }
                    // Tronquer le message aussi (au cas où il serait long)
                    let message = value.messages.length > 27
                    ? value.messages.substring(0, 27) + '...'
                    : value.messages;

                $('#notification-box').append(
                    ` <div class="ground ground-list-single">
                        <div class="btn-circle-40 btn-info">
                        <i class="fa fa-balance-scale"></i>
                        </div>
                    <div class="ground-content">
                    <a href="/audience/view/${value.idAudience}/${value.slug}/${value.niveauProcedural}" id="${value.urlParam}" class="${value.id}"  onclick=" var param=this.id ; var idNotif=this.className; voir(param,idNotif)"><h5><b> ${h5Text} </b></h5></a>
                    <small class="text-fade">${value.messages}</small>
                    </div></div>`
                )

                console.log(response.newNotifAudience);

                


            });

            $.each(response.newNotifSuiviAppel, function(key, value) {
                  // Construire le contenu du h5
                  let h5Text = ` ${value.idClient || ''} > ${value.prenom || ''} ${value.nom || ''} ${value.denomination || ''}> ${value.idAffaire || ''}  ${value.nomAffaire || ''}`;

                    // Tronquer h5 si plus de 27 caractères
                    if (h5Text.length > 30) {
                        h5Text = h5Text.substring(0, 30) + '...';
                    }
                        // Tronquer le message aussi (au cas où il serait long)
                let message = value.messages.length > 27
                    ? value.messages.substring(0, 27) + '...'
                    : value.messages;

                $('#notification-box').append(
                    ` <div class="ground ground-list-single">
                        <div class="btn-circle-40 btn-info">
                        <i class="fa fa-balance-scale"></i>
                        </div>
                    <div class="ground-content">
                    <a href="/audience/view/${value.idAudience}/${value.slug}/${value.niveauProcedural}" id="${value.urlParam}" class="${value.id}"  onclick=" var param=this.id ; var idNotif=this.className; voir(param,idNotif)"><h5><b>  ${h5Text} </b></h5></a>
                    <small class="text-fade">${value.messages}</small>
                    </div></div>`
                )
                console.log(response.newNotifSuiviAppel);


            });

            $.each(response.newNotifRequeteSuivi, function(key, value) {
                // Construire le contenu du h5
                let h5Text = `${value.idClient || ''} > ${value.prenom || ''} ${value.nom || ''} ${value.denomination || ''}> ${value.idAffaire || ''}  ${value.nomAffaire || ''}`;

                // Tronquer h5 si plus de 27 caractères
                if (h5Text.length > 30) {
                    h5Text = h5Text.substring(0, 30) + '...';
                }
                    // Tronquer le message aussi (au cas où il serait long)
                    let message = value.messages.length > 27
                    ? value.messages.substring(0, 27) + '...'
                    : value.messages;

                $('#notification-box').append(
                    ` <div class="ground ground-list-single">
                <div class="btn-circle-40 btn-info">
                <i class="fa fa-balance-scale"></i>
                </div>
                <div class="ground-content">
                <a href="/requete/detail/${value.slug}" id="${value.urlParam}" class="${value.id}"  onclick=" var param=this.id ; var idNotif=this.className; voir(param,idNotif)"><h5><b> ${h5Text}</b></h5></a>
                <small class="text-fade">${value.messages}</small>
                </div></div>`
                )
                console.log(response.newNotifRequeteSuivi);
             
            });

            $.each(response.newNotifRequete, function(key, value) {
                 // Construire le contenu du h5
                let h5Text = `${value.idClientRequete || ''} > ${value.prenomRequete || ''} ${value.nomRequete || ''} ${value.denomination || ''}> ${value.idAffaireRequete || ''}  ${value.nomAffaireRequete || ''}`;

                // Tronquer h5 si plus de 27 caractères
                if (h5Text.length > 30) {
                    h5Text = h5Text.substring(0, 30) + '...';
                }

                // Tronquer le message aussi (au cas où il serait long)
                let message = value.messages.length > 27
                    ? value.messages.substring(0, 27) + '...'
                    : value.messages;
              
                $('#notification-box').append(
                    `<div class="ground ground-list-single">
                        <div class="btn-circle-40 btn-info">
                            <i class="fa fa-balance-scale"></i>
                        </div>
                        <div class="ground-content">
                            <a href="/requete/detail/${value.slug}" id="${value.urlParam}" class="${value.id}"
                                onclick="var param=this.id; var idNotif=this.className; voir(param,idNotif)">
                                <h5><b> ${h5Text}</b></h5>
                            </a>
                            <small class="text-fade">${value.messages}</small>
                        </div>
                    </div>`
                );

              
            });


           // console.log(value);

            $.each(response.newNotifsFacture, function(key, value) {

                // Construire le contenu du h5
                let h5Text = `${value.idClient || ''} > ${value.prenom || ''}${value.nom || ''} ${value.denomination || ''} > ${value.idAffaire || ''}  ${value.nomAffaire || ''}`;

                // Tronquer h5 si plus de 27 caractères
                if (h5Text.length > 30) {
                    h5Text = h5Text.substring(0, 30) + '...';
                }

                // Tronquer le message aussi (au cas où il serait long)
                let message = value.messages.length > 27
                    ? value.messages.substring(0, 27) + '...'
                    : value.messages;


                $('#notification-box').append(
                    ` <div class="ground ground-list-single">
             <div class="btn-circle-40 btn-info">
             <i class="fa fa-money"></i>
             </div>
           <div class="ground-content">
           <a href="/facturation/show/${value.slug}" id="${value.urlParam}" class="${value.id}"  onclick=" var param=this.id ; var idNotif=this.className; voir(param,idNotif)"><h5><b>${h5Text} </b></h5></a>
           <small class="text-fade">${value.messages}</small>
           </div></div>`
                )


            });

            $('#nbNotif').append(
                `<span class="a-dropdown--title" >${nbre} Notification(s)</span>`)



        },
        error: function(jqXHR, textStatus, errorThrown) {
            //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
        }
    });


}

function playsound() {
    var sound = document.getElementById("son");
    sound.play();
}

function searchAvocat() {

    var idAvocat = $('#avocat').val();

    $.ajax({
        type: "GET",
        url: `/fetch-avocats/${idAvocat}`,
        dataType: "json",
        success: function(response) {

           // console.log(response);

            $.each(response.avocat, function(key, value) {

                document.getElementById('inputDAV').value = value.prenomAvc;
                document.getElementById('inputNAV').value = value.nomAvc;
                document.getElementById('inputPAV').value = value.adresseAvc;
                document.getElementById('inputFAV').value = value.telAvc_1;
                document.getElementById('inputRPAV').value = value.emailAvc_1;
            });


        },

        error: function(jqXHR, textStatus, errorThrown) {
            //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
        }
    });


}

function updateAvocat(id) {


    $.ajax({
        type: "GET",
        url: `/fetch-avocats/${id}`,
        dataType: "json",
        success: function(response) {

            $.each(response.avocat, function(key, value) {
                $('#annee_entrer').val(value.annee_entrer);
                $('#prenomAvc').val(value.prenomAvc);
                $('#nomAvc').val(value.nomAvc);
                $('#telAvc_1').val(value.telAvc_1);
                $('#telAvc_2').val(value.telAvc_2);
                $('#emailAvc').val(value.emailAvc_1);
                $('#adresseAvc').val(value.adresseAvc);
                $('#idAvc').val(value.idAvc);
            });

        },
        error: function(jqXHR, textStatus, errorThrown) {
            //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
        }
    });


}

function updateContact(id) {

$.ajax({
    type: "GET",
    url: `/fetch-contacts/${id}`,
    dataType: "json",
    success: function(response) {
        $.each(response.contact, function(key, value) {
            $('#societeContact').val(value.societe);
            $('#prenom_et_nomContact').val(value.prenom_et_nom);
            $('#poste_de_responsabiliteContact').val(value.poste_de_responsabilite);
            $('#telephoneContact').val(value.telephone);
            $('#emailContact').val(value.email);
            $('#idContact').val(value.id);
           
        });

    },
    error: function(jqXHR, textStatus, errorThrown) {
        //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
    }
});


}

function updateHuissier(id) {


    $.ajax({
        type: "GET",
        url: `/fetch-huissiers/${id}`,
        dataType: "json",
        success: function(response) {

            $.each(response.huissier, function(key, value) {
                $('#rattachement').val(value.rattachement);
                $('#prenomHss').val(value.prenomHss);
                $('#nomHss').val(value.nomHss);
                $('#telHss_1').val(value.telHss_1);
                $('#telHss_2').val(value.telHss_2);
                $('#emailHss').val(value.emailHss);
                $('#adresseHss').val(value.adresseHss);
                $('#idHss').val(value.idHss);
            });

        },
        error: function(jqXHR, textStatus, errorThrown) {
            //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
        }
    });


}

function deleteAvocat(id) {
    $('#idAvocat').val(id);
}
function deleteContact(id) {
    $('#idContactDelete').val(id);
}

function deleteCourierArriver(id) {
    $('#slugCourier').val(id);
}

function deleteCourierDepart(id) {
    $('#slugCourier2').val(id);
}

function deleteHuissier(id) {
    $('#idHuissier').val(id);
}
</script>
<script>
$('.dropdown-toggle').dropdown()
</script>

<script type="text/javascript" src="{{ asset('assets/DataTables/js/jquery-3.5.1.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/DataTables/js/dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/DataTables/js/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/DataTables/js/jszip.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/DataTables/js/pdfmake.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/DataTables/js/vfs_fonts.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/DataTables/js/buttons.html5.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/DataTables/js/buttons.print.min.js') }}"></script>


<script type="text/javascript">
$(document).ready(function() {
    console.warn = () => {};

    $('#conclusion').attr('hidden', true);
    $('#invitationAconclure').attr('hidden', true);
    $('#injonctionAconclure').attr('hidden', true);
    $('#pvConstat').attr('hidden', true);
    $('#avenirConstat').attr('hidden', true);
    $('#miseDeliberer').attr('hidden', true);
    $('#delibererProroger').attr('hidden', true);
    $('#viderDeliberer').attr('hidden', true);
    $('#conference').attr('hidden', true);
    $('#Renvoi').attr('hidden', true);
    $('#autreActe').attr('hidden', true);


    // Initialisation des checkbox de personnel info
    $('#elementContratDate').attr('hidden', true);
    $('#elementAccord').attr('hidden', true);
    $('#elementContraModif').attr('hidden', true);
    $('#elementContratTerminer').attr('hidden', true);
    $('#divImporter').attr('hidden', true);
    $('#divRediger').attr('hidden', true);

    $('#checkbox1').on('click', function() {
        var maCaseACocher = document.getElementById("checkbox1");
        if (maCaseACocher.checked) {
            $('#elementContratDate').removeAttr('hidden');
        } else {
            $('#elementContratDate').attr('hidden', true);
        }
    });

    $('#checkbox2').on('click', function() {
        var maCaseACocher = document.getElementById("checkbox2");
        if (maCaseACocher.checked) {
            $('#elementAccord').removeAttr('hidden');
        } else {
            $('#elementAccord').attr('hidden', true);
        }
    });

    $('#checkbox3').on('click', function() {
        var maCaseACocher = document.getElementById("checkbox3");
        if (maCaseACocher.checked) {
            $('#elementContraModif').removeAttr('hidden');
        } else {
            $('#elementContraModif').attr('hidden', true);
        }
    });

    $('#checkbox4').on('click', function() {
        var maCaseACocher = document.getElementById("checkbox4");
        if (maCaseACocher.checked) {
            $('#elementContratTerminer').removeAttr('hidden');
        } else {
            $('#elementContratTerminer').attr('hidden', true);
        }
    });

    $('#CheckboxRediger').on('click', function() {
        $('#divRediger').removeAttr('hidden');
        $('#divImporter').attr('hidden', true);
    });

    $('#CheckboxImporter').on('click', function() {
        $('#divImporter').removeAttr('hidden');
        $('#divRediger').attr('hidden', true);
    });



    

    

    //Un seule filtre a la fois 
    
    $("#filterTable_filter.dataTables_filter").append($(".categoryFilter"));

    $(".categoryFilter").change(function(e) {

        var table = $('.filterTable').DataTable();
            var categoryIndex = 0;
            $("#filterTable th").each(function(i) {
                if ($($(this)).html() == "Statut") {
                    categoryIndex = i;
                    return false;
                }
                if ($($(this)).html() == "Niveau Procedural") {
                    categoryIndex = i;
                    return false;
                }
                if ($($(this)).html() == "Role") {
                    categoryIndex = i;
                    return false;
                }
            });

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var selectedItem = $('.categoryFilter').val()
                    var category = data[categoryIndex];
                    if (selectedItem === "" || category.includes(selectedItem)) {
                        return true;
                    }
                    return false;
                }
            );

        table.draw();
    });


    // **Réinitialiser la recherche si le collapse s'ouvre**
    $('#collapseOne').on('shown.bs.collapse', function () {
        var table = $('.filterTable').DataTable();
        $(".categoryFilter").val(""); // Réinitialiser le filtre
        $.fn.dataTable.ext.search = []; // Supprimer les filtres actifs
        table.search("").draw(); // Effacer la recherche et rafraîchir le tableau
    });

    // **Réinitialiser la recherche si le collapse se ferme**
    $('#collapseOne').on('hidden.bs.collapse', function () {
        var table = $('.filterTable').DataTable();
        $(".categoryFilter").val(""); // Réinitialiser le filtre
        $.fn.dataTable.ext.search = []; // Supprimer les filtres actifs
        table.search("").draw(); // Effacer la recherche et rafraîchir le tableau
    });
    

    $("#filterTable3_filter.dataTables_filter").append($(".categoryFilter3"));

    $(".categoryFilter3").change(function(e) {

        var table = $('.filterTable3').DataTable();
            var categoryIndex = 0;
            $("#filterTable3 th").each(function(i) {
                if ($($(this)).html() == "Statut") {
                    categoryIndex = i;
                    return false;
                }
            });

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var selectedItem = $('.categoryFilter3').val()
                    var category = data[categoryIndex];
                    if (selectedItem === "" || category.includes(selectedItem)) {
                        return true;
                    }
                    return false;
                }
            );

        table.draw();
    });

    // **Réinitialiser la recherche si le collapse s'ouvre**
    $('#collapseTwo').on('shown.bs.collapse', function () {
        var table = $('.filterTable3').DataTable();
        $(".categoryFilter3").val(""); // Réinitialiser le filtre
        $.fn.dataTable.ext.search = []; // Supprimer les filtres actifs
        table.search("").draw(); // Effacer la recherche et rafraîchir le tableau
    });

    // **Réinitialiser la recherche si le collapse se ferme**
    $('#collapseTwo').on('hidden.bs.collapse', function () {
        var table = $('.filterTable3').DataTable();
        $(".categoryFilter3").val(""); // Réinitialiser le filtre
        $.fn.dataTable.ext.search = []; // Supprimer les filtres actifs
        table.search("").draw(); // Effacer la recherche et rafraîchir le tableau
    });


     //  filtre  courriers depart * infoClient.blade.php && affaireinfo.blade.php *


     $("#filterTable4_filter.dataTables_filter").append($(".categoryFilter4"));

$(".categoryFilter4").change(function(e) {

    var table = $('.filterTable4').DataTable();
        var categoryIndex = 0;
        $("#filterTable4 th").each(function(i) {
            if ($($(this)).html() == "Statut") {
                categoryIndex = i;
                return false;
            }
        
        });

        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var selectedItem = $('.categoryFilter4').val()
                var category = data[categoryIndex];
                if (selectedItem === "" || category.includes(selectedItem)) {
                    return true;
                }
                return false;
            }
        );

    table.draw();
});

// **Réinitialiser la recherche si le collapse s'ouvre**
$('#collapseOne').on('shown.bs.collapse', function () {
    var table = $('.filterTable4').DataTable();
    $(".categoryFilter4").val(""); // Réinitialiser le filtre
    $.fn.dataTable.ext.search = []; // Supprimer les filtres actifs
    table.search("").draw(); // Effacer la recherche et rafraîchir le tableau
});

// **Réinitialiser la recherche si le collapse se ferme**
$('#collapseOne').on('hidden.bs.collapse', function () {
    var table = $('.filterTable4').DataTable();
    $(".categoryFilter4").val(""); // Réinitialiser le filtre
    $.fn.dataTable.ext.search = []; // Supprimer les filtres actifs
    table.search("").draw(); // Effacer la recherche et rafraîchir le tableau
});


$("#filterTable5_filter.dataTables_filter").append($(".categoryFilter5"));

$(".categoryFilter5").change(function(e) {

    var table = $('.filterTable5').DataTable();
        var categoryIndex = 0;
        $("#filterTable5 th").each(function(i) {
            if ($($(this)).html() == "Statut") {
                categoryIndex = i;
                return false;
            }
        
        });

        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var selectedItem = $('.categoryFilter5').val()
                var category = data[categoryIndex];
                if (selectedItem === "" || category.includes(selectedItem)) {
                    return true;
                }
                return false;
            }
        );

    table.draw();
});

$("#filterTable6_filter.dataTables_filter").append($(".categoryFilter6"));

$(".categoryFilter6").change(function(e) {

    var table = $('.filterTable6').DataTable();
        var categoryIndex = 0;
        $("#filterTable6 th").each(function(i) {
            if ($($(this)).html() == "Statut") {
                categoryIndex = i;
                return false;
            }
        
        });

        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var selectedItem = $('.categoryFilter6').val()
                var category = data[categoryIndex];
                if (selectedItem === "" || category.includes(selectedItem)) {
                    return true;
                }
                return false;
            }
        );

    table.draw();
});






//  fin  filtre  courriers depart * infoClient.blade.php *
    


    // Deux filtre a la fois
    $("#filterTable2_filter.dataTables_filter").append($(".categoryFilter1")); 
    $("#filterTable2_filter.dataTables_filter").append($(".categoryFilter2")); 

    $(".categoryFilter1, .categoryFilter2").change(function(e) {

                var table = $('.filterTable2').DataTable();

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var selectedItem1 = $('.categoryFilter1').val();
                    var category1 = data[4]; 

                    var selectedItem2 = $('.categoryFilter2').val();
                    var category2 = data[6]; 

                    return (selectedItem1 === "" || category1.includes(selectedItem1)) &&
                        (selectedItem2 === "" || category2.includes(selectedItem2));
                }
            );

        table.draw();
    });





});
</script>




<script src="{{ asset('assets/build/js/intlTelInput.js') }}"></script>
<script>
var input = document.querySelector('.phone');
window.intlTelInput(input, {
    initialCountry: 'gn',
    nationalMode: true,
});


var input1 = document.querySelector('.phone1');
window.intlTelInput(input1, {
    initialCountry: 'gn',
    nationalMode: true,
});

var input2 = document.querySelector('.phone2');
window.intlTelInput(input2, {
    initialCountry: 'gn',
    nationalMode: true,
});

var input3 = document.querySelector('.phone3');
window.intlTelInput(input3, {
    initialCountry: 'gn',
    nationalMode: true,
});
</script>

<script src="{{ asset('assets/paginga.jquery.js') }}"></script>

<script>
$(function() {
    $(".paginate").paginga({
        // use default options
        // how many items per page
        itemsPerPage: 18,
    });

    $(".paginate-page-2").paginga({
        page: 2
    });

    $(".paginate-no-scroll").paginga({
        scrollToTop: false
    });
});
</script>


<!-- Scripts audiences-->
<script>
function typeAvocat(id) {

    const typeAvocat = "#typeAvocat-" + id;
    const clientContent = "#clientContent-" + id;
    const otherAvocats = "#otherAvocats-" + id;
    const affaireContent = "#affaireContent-" + id;
    const personneExterne = "#personneExterne-" + id;
    const typeAdverse1 = "#typeAdverse1-" + id;
    const client = "#client-" + id;
    const affaireClient = "#affaireClient-" + id;

    var type = $(typeAvocat).val();

    if (type == '1') {
        $(clientContent).removeAttr('hidden');
        $(otherAvocats).removeAttr('hidden');
        $(typeAdverse1).removeAttr('required');
        $(personneExterne).attr('hidden', true);
        $(client).attr('required', true);
        $(affaireClient).attr('required', true);

    } else {
        $(clientContent).attr('hidden', true);
        $(affaireContent).attr('hidden', true);
        $(personneExterne).removeAttr('hidden');
        $(otherAvocats).removeAttr('hidden');
        $(typeAdverse1).attr('required', true);
        $(client).removeAttr('required');
        $(affaireClient).removeAttr('required');
    }

};

function clientAud(idclient, id) {


    const t = "#typeContent-" + id;
    const affaireContent = "#affaireContent-" + id;
    const affaireClient = "#affaireClient-" + id;
    $(affaireContent).removeAttr('hidden');
    $(affaireClient).removeAttr('hidden');


    var typeContent = $(t).val();
    $.ajax({
        type: "GET",
        url: `/fetch-affaire/${idclient}`,
        dataType: "json",
        success: function(response) {
            $(affaireClient).html("");

            $.each(response.affaire, function(key, value) {
                $(affaireClient).append(
                    `<option value=${value.idAffaire}> ${value.nomAffaire}</option>`)
            });


        },
        error: function(jqXHR, textStatus, errorThrown) {
            //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
        }
    });
};

$('#requeteLier').on("change", function() {

    var requeteLier = $('#requeteLier').val();

    if (requeteLier == 'oui') {
        $('#clientContent-req').removeAttr('hidden');
    }else{
        $('#clientContent-req').attr('hidden', true);
        $('#affaireContent-req').attr('hidden', true);
        $('#clientProcedure-req').attr('hidden', true);
    }

});

$('#affaireClient-req').on("change", function() {

   // Route ajax pour reccuperer les procedures de requetes pour cette affaire.
  
});




/*
function fechRequeteClient(idClient) {

    $('#requeteContent').removeAttr('hidden');
    $.ajax({
        type: "GET",
        url: `/fetch-requete/${idClient}`,
        dataType: "json",

        success: function(response) {
            $('#requeteClient').html("");
            $('#requeteClient').append(
                `<option disabled>-- Choisissez --</option>`);

            //console.log(response);
            $.each(response.requeteClientFetch, function(key, value) {
                $('#requeteClient').append(
                    `<option value=${value.slug}> ${value.objet}</option>`
                )
            });
        
        },
        error: function(jqXHR, textStatus, errorThrown) {
        // console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
        }
    });
}
    */

function fechRequeteClient(idClient) {

    var currentSlug = $('#currentSlug').val(); // récupère le slug actuel

    $('#requeteContent').removeAttr('hidden');
    $.ajax({
        type: "GET",
        url: `/fetch-requete/${idClient}`,
        data: { slugProcedure: currentSlug }, // <= ENVOI DU SLUG EN COURS
        dataType: "json",

        success: function(response) {
            $('#requeteClient').html("");
            $('#requeteClient').append(
                `<option disabled>-- Choisissez --</option>`);

            //console.log(response);
            $.each(response.requeteClientFetch, function(key, value) {
                $('#requeteClient').append(
                    `<option value=${value.slug}> ${value.objet}</option>`
                )
            });

        },
        error: function(jqXHR, textStatus, errorThrown) {
        // console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
        }
    });
}

function clientReqFunction(idclient) {

        const affaireContent = "#affaireContent-req";
        const affaireClient = "#affaireClient-req";
        $(affaireContent).removeAttr('hidden');
        $(affaireClient).removeAttr('hidden');
        $('#clientProcedure-req').removeAttr('hidden');
        fechRequeteClient(idclient);


        $.ajax({
            type: "GET",
            url: `/fetch-affaire/${idclient}`,
            dataType: "json",
            success: function(response) {
                $(affaireClient).html("");

                $.each(response.affaire, function(key, value) {
                    $(affaireClient).append(
                        `<option value=${value.idAffaire}> ${value.nomAffaire}</option>`)
                });


            },
            error: function(jqXHR, textStatus, errorThrown) {
                //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
            }
        });


};


//checkbox demandeur
function roleASKa(id) {

    const avc = "#avc-" + id;
    const other = "#other-" + id;
    const otherAvocats = "#otherAvocats-" + id;
    const affaireContent = "#affaireContent-" + id;
    const clientContent = "#clientContent-" + id;
    const mp = "#mp-" + id;
    const personneExterne = "#personneExterne-" + id;


    // pour reinitialiser le select
    const typeAvocat = "#typeAvocat-" + id;


    $(avc).removeAttr('hidden');
    $(other).attr('hidden', true);
    $(otherAvocats).attr('hidden', true);
    $(affaireContent).attr('hidden', true);
    $(clientContent).attr('hidden', true);
    $(mp).attr('hidden', true);
    $(personneExterne).attr('hidden', true);
    $(typeAvocat).attr('required', true);




};

// checkbox defendeur
function roleASKb(id) {

    const avc = "#avc-" + id;
    const other = "#other-" + id;
    const otherAvocats = "#otherAvocats-" + id;
    const affaireContent = "#affaireContent-" + id;
    const clientContent = "#clientContent-" + id;
    const mp = "#mp-" + id;
    const personneExterne = "#personneExterne-" + id;

    $(avc).removeAttr('hidden');
    $(other).attr('hidden', true);
    $(otherAvocats).attr('hidden', true);
    $(affaireContent).attr('hidden', true);
    $(clientContent).attr('hidden', true);
    $(mp).attr('hidden', true);
    $(personneExterne).attr('hidden', true);

};

// checkbox autre
function roleASKc(id) {
    const avc = "#avc-" + id;
    const other = "#other-" + id;
    const otherAvocats = "#otherAvocats-" + id;
    const affaireContent = "#affaireContent-" + id;
    const clientContent = "#clientContent-" + id;
    const mp = "#mp-" + id;
    const personneExterne = "#personneExterne-" + id;

    $(other).removeAttr('hidden');
    $(avc).attr('hidden');
    $(otherAvocats).attr('hidden', true);
    $(affaireContent).attr('hidden', true);
    $(clientContent).attr('hidden', true);
    $(mp).attr('hidden', true);
    $(personneExterne).attr('hidden', true);
};

function otherSelect(id) {

    const avc = "#avc-" + id;
    const other = "#other-" + id;
    const otherSelect = "#otherSelect-" + id;
    const otherAvocats = "#otherAvocats-" + id;
    const affaireContent = "#affaireContent-" + id;
    const clientContent = "#clientContent-" + id;
    const mp = "#mp-" + id;
    const personneExterne = "#personneExterne-" + id;
    const typeAvocat = "#typeAvocat-" + id;

    var valueSelect = $(otherSelect).val();
    if (valueSelect == 'mp') {
        $(clientContent).attr('hidden', true);
        $(personneExterne).attr('hidden', true);
        $(affaireContent).attr('hidden', true);
        $(otherAvocats).attr('hidden', true);
        $(avc).attr('hidden', true);
        $(mp).removeAttr('hidden');
        $(otherSelect).removeAttr('required');
        $(typeAvocat).removeAttr('required');
        $(otherAvocats).attr('hidden');
    } else {
        $(avc).removeAttr('hidden');
        $(other).removeAttr('hidden');
        $(otherAvocats).attr('hidden', true);
        $(otherSelect).attr('required');
        $(typeAvocat).attr('required');
        $(affaireContent).attr('hidden', true);
        $(clientContent).attr('hidden', true);
        $(mp).attr('hidden', true);
        $(personneExterne).attr('hidden', true);
    }
};


function sendbyphysique() {

    $('#formEnvoiPhysique').removeAttr('hidden');
    $('#formEnvoiMail').attr('hidden', true);

};

function sendbymail() {

    $('#formEnvoiMail').removeAttr('hidden');
    $('#formEnvoiPhysique').attr('hidden', true);

};


function natureAud() {
    var niveauProcedural = $('#niveauProcedural').val();
    var nature = $('#nature').val();

    if (niveauProcedural == '1ère instance' && nature == 'Civile') {

        // inclure premiereInstanceCivile.blade.php

        var xhr = new XMLHttpRequest();

        xhr.onload = function() {
            if (xhr.status === 200) {
                var contenuPage = xhr.responseText;

                var monDiv = document.getElementById("audienceFormContent");
                monDiv.innerHTML = "";
                monDiv.innerHTML = contenuPage;
            }
        };

        xhr.open("GET", "/premiereInstanceCivile", true);
        xhr.send();

        $('#formInstruction').attr('hidden', true);
    }

    if (niveauProcedural == '1ère instance' && nature == 'Pénale') {

        // inclure premiereInstanceCivile.blade.php

        var xhr = new XMLHttpRequest();

        xhr.onload = function() {
            if (xhr.status === 200) {
                var contenuPage = xhr.responseText;

                var monDiv = document.getElementById("audienceFormContent");
                monDiv.innerHTML = "";
                monDiv.innerHTML = contenuPage;
            }
        };

        xhr.open("GET", "/premiereInstancePenale", true);
        xhr.send();

        $('#formInstruction').removeAttr('hidden');
    }

    if (niveauProcedural == 'Appel' && nature == 'Civile') {

        // inclure premiereInstanceCivile.blade.php

        var xhr = new XMLHttpRequest();

        xhr.onload = function() {
            if (xhr.status === 200) {
                var contenuPage = xhr.responseText;

                var monDiv = document.getElementById("audienceFormContent");
                monDiv.innerHTML = "";
                monDiv.innerHTML = contenuPage;
            }
        };

        xhr.open("GET", "/appel", true);
        xhr.send();

        $('#formInstruction').attr('hidden', true);
    }

    if (niveauProcedural == 'Appel' && nature == 'Pénale') {

        // inclure premiereInstanceCivile.blade.php

        var xhr = new XMLHttpRequest();

        xhr.onload = function() {
            if (xhr.status === 200) {
                var contenuPage = xhr.responseText;

                var monDiv = document.getElementById("audienceFormContent");
                monDiv.innerHTML = "";
                monDiv.innerHTML = contenuPage;
            }
        };

        xhr.open("GET", "/appel", true);
        xhr.send();

        $('#formInstruction').removeAttr('hidden');

    }

    if (niveauProcedural == 'Cassation' && nature == 'Civile') {

        // inclure premiereInstanceCivile.blade.php

        var xhr = new XMLHttpRequest();

        xhr.onload = function() {
            if (xhr.status === 200) {
                var contenuPage = xhr.responseText;

                var monDiv = document.getElementById("audienceFormContent");
                monDiv.innerHTML = "";
                monDiv.innerHTML = contenuPage;
            }
        };

        xhr.open("GET", "/cassation", true);
        xhr.send();

        $('#formInstruction').attr('hidden', true);
    }

    if (niveauProcedural == 'Cassation' && nature == 'Pénale') {

        // inclure premiereInstanceCivile.blade.php

        var xhr = new XMLHttpRequest();

        xhr.onload = function() {
            if (xhr.status === 200) {
                var contenuPage = xhr.responseText;

                var monDiv = document.getElementById("audienceFormContent");
                monDiv.innerHTML = "";
                monDiv.innerHTML = contenuPage;
            }
        };

        xhr.open("GET", "/cassation", true);
        xhr.send();

        $('#formInstruction').removeAttr('hidden');
    }
    


};


// Premiere Instance civile
function formAssignation() {
    $('#formAssignation').removeAttr('hidden');
    //$('#numRg').attr('required', true);
    $('#huissierAssign').attr('required', true);
    $('#recepteurAss').attr('required', true);
    $('#dateAssignation').attr('required', true);
    $('#datePremiereComp').attr('required', true);
    $('#dateEnrollement').attr('required', true);
    $('#mentionParticuliereAssign').attr('required', true);
    $('#pieceAS').attr('required', true);
    $('#pieceREQ').removeAttr('required');
    $('#pieceOPP').removeAttr('required'); 
    

    $('#formRequete').attr('hidden', true);
    //$('#numRgRequete').removeAttr('required');
    $('#dateRequete').removeAttr('required');
    $('#dateArriver').removeAttr('required');
    $('#juriductionPresidentielle').removeAttr('required');


    $('#formOpposition').attr('hidden', true);
    $('#numRgOpp').removeAttr('required');
    $('#idHuissierOpp').removeAttr('required');
    $('#recepteurAssOpp').removeAttr('required');
    $('#datePremiereCompOpp').removeAttr('required');
    $('#dateEnrollementOpp').removeAttr('required');
    $('#dateProchaineAud').removeAttr('required');
    $('#numDecision').removeAttr('required');
    $('#mentionParticuliereOpp').removeAttr('required');

    $('#formCitation').attr('hidden', true);
    $('#idHuissierCit').removeAttr('required');
    $('#dateSignification').removeAttr('required');
    $('#personneCharger').removeAttr('required');
    $('#numRgCitation').removeAttr('required');
    $('#dateCitation').removeAttr('required');
    $('#dateAudienceCitation').removeAttr('required');
    $('#lieuAudience').removeAttr('required');
    $('#pieceCitation').removeAttr('required');

    $('#formAutre').attr('hidden', true);
    $('#mention').removeAttr('required');
    $('#valeur').removeAttr('required');



}

function formRequete() {


    $('#formAssignation').attr('hidden', true);
    //$('#numRg').removeAttr('required');
    $('#huissierAssign').removeAttr('required');
    $('#recepteurAss').removeAttr('required');
    $('#dateAssignation').removeAttr('required');
    $('#datePremiereComp').removeAttr('required');
    $('#dateEnrollement').removeAttr('required');
    $('#mentionParticuliereAssign').removeAttr('required');
    $('#pieceAS').removeAttr('required');    
    $('#pieceREQ').attr('required', true);
    $('#pieceOPP').removeAttr('required'); 
    $('#formRequete').removeAttr('hidden');
    //$('#numRgRequete').attr('required', true);
    $('#dateRequete').attr('required', true);
    $('#dateArriver').attr('required', true);
    $('#juriductionPresidentielle').attr('required', true);


    $('#formOpposition').attr('hidden', true);
    $('#numRgOpp').removeAttr('required');
    $('#idHuissierOpp').removeAttr('required');
    $('#recepteurAssOpp').removeAttr('required');
    $('#datePremiereCompOpp').removeAttr('required');
    $('#dateEnrollementOpp').removeAttr('required');
    $('#dateProchaineAud').removeAttr('required');
    $('#numDecision').removeAttr('required');
    $('#mentionParticuliereOpp').removeAttr('required');
}

function formOpposition() {

    $('#formAssignation').attr('hidden', true);
    //$('#numRg').removeAttr('required');
    $('#huissierAssign').removeAttr('required');
    $('#recepteurAss').removeAttr('required');
    $('#dateAssignation').removeAttr('required');
    $('#datePremiereComp').removeAttr('required');
    $('#dateEnrollement').removeAttr('required');
    $('#mentionParticuliereAssign').removeAttr('required');
    $('#pieceAS').removeAttr('required');
    $('#pieceREQ').removeAttr('required');
    $('#pieceOPP').attr('required', true);

    $('#formRequete').attr('hidden', true);
    //$('#numRgRequete').removeAttr('required');
    $('#dateRequete').removeAttr('required');
    $('#dateArriver').removeAttr('required');
    $('#juriductionPresidentielle').removeAttr('required');


    $('#formOpposition').removeAttr('hidden', true);
    $('#numRgOpp').attr('required', true);
    $('#idHuissierOpp').attr('required', true);
    $('#recepteurAssOpp').attr('required', true);
    $('#datePremiereCompOpp').attr('required', true);
    $('#dateEnrollementOpp').attr('required', true);
    $('#dateProchaineAud').attr('required', true);
    $('#numDecision').attr('required', true);
    $('#mentionParticuliereOpp').attr('required', true);

    $('#formCitation').attr('hidden', true);
    $('#idHuissierCit').removeAttr('required');
    $('#dateSignification').removeAttr('required');
    $('#personneCharger').removeAttr('required');
    $('#numRgCitation').removeAttr('required');
    $('#dateCitation').removeAttr('required');
    $('#dateAudienceCitation').removeAttr('required');
    $('#lieuAudience').removeAttr('required');
    $('#pieceCitation').removeAttr('required');

    $('#formAutre').attr('hidden', true);
    $('#mention').removeAttr('required');
    $('#valeur').removeAttr('required');
}


// Premiere Instance penale
function formPvInterogatoire() {
    $('#formPvInterogatoire').removeAttr('hidden', true);
    $('#dateAudition').attr('required', true);
    $('#infractions').attr('required', true);
    $('#dateAudience').attr('required', true);


    $('#formRequisitoire').attr('hidden', true);
    $('#chefAccusationReq').removeAttr('required');

    $('#formOrdonnanceRenvoi').attr('hidden', true);
    $('#numOrd').removeAttr('required');
    $('#cabinetIns').removeAttr('required');
    $('#typeProcedure').removeAttr('required');
    $('#numOrd').removeAttr('required');

    $('#formCitationDirect').attr('hidden', true);
    $('#idSaisiPar').removeAttr('required');
    $('#recepteurCitation').removeAttr('required');
    $('#mentionParticuliere').removeAttr('required');
    $('#chefAccusation').removeAttr('required');

    $('#formPcpc').attr('hidden', true);
    $('#datePcpc').removeAttr('required');
    $('#reference').removeAttr('required');
    $('#idSaisiPar').removeAttr('required');
    $('#dateProchaineAud').removeAttr('required');

}

function formRequisitoire() {



    $('#formPvInterogatoire').attr('hidden', true);
    $('#dateAudition').removeAttr('required');
    $('#infractions').removeAttr('required');
    $('#dateAudience').removeAttr('required');


    $('#formRequisitoire').removeAttr('hidden', true);
    $('#chefAccusationReq').attr('required', true);

    $('#formOrdonnanceRenvoi').attr('hidden', true);
    $('#numOrd').removeAttr('required');
    $('#cabinetIns').removeAttr('required');
    $('#typeProcedure').removeAttr('required');
    $('#numOrd').removeAttr('required');

    $('#formCitationDirect').attr('hidden', true);
    $('#idSaisiPar').removeAttr('required');
    $('#recepteurCitation').removeAttr('required');
    $('#mentionParticuliere').removeAttr('required');
    $('#chefAccusation').removeAttr('required');

    $('#formPcpc').attr('hidden', true);
    $('#datePcpc').removeAttr('required');
    $('#reference').removeAttr('required');
    $('#idSaisiPar').removeAttr('required');
    $('#dateProchaineAud').removeAttr('required');
}

function formOrdonnanceRenvoi() {
    $('#formPvInterogatoire').attr('hidden', true);
    $('#dateAudition').removeAttr('required');
    $('#infractions').removeAttr('required');
    $('#dateAudience').removeAttr('required');


    $('#formRequisitoire').attr('hidden', true);
    $('#chefAccusationReq').removeAttr('required');

    $('#formOrdonnanceRenvoi').removeAttr('hidden', true);
    $('#numOrd').attr('required', true);
    $('#cabinetIns').attr('required', true);
    $('#typeProcedure').attr('required', true);
    $('#numOrd').attr('required', true);

    $('#formCitationDirect').attr('hidden', true);
    $('#idSaisiPar').removeAttr('required');
    $('#recepteurCitation').removeAttr('required');
    $('#mentionParticuliere').removeAttr('required');
    $('#chefAccusation').removeAttr('required');

    $('#formPcpc').attr('hidden', true);
    $('#datePcpc').removeAttr('required');
    $('#reference').removeAttr('required');
    $('#idSaisiPar').removeAttr('required');
    $('#dateProchaineAud').removeAttr('required');
}

function formCitationDirect() {
    $('#formPvInterogatoire').attr('hidden', true);
    $('#dateAudition').removeAttr('required');
    $('#infractions').removeAttr('required');
    $('#dateAudience').removeAttr('required');


    $('#formRequisitoire').attr('hidden', true);
    $('#chefAccusationReq').removeAttr('required');

    $('#formOrdonnanceRenvoi').attr('hidden', true);
    $('#numOrd').removeAttr('required');
    $('#cabinetIns').removeAttr('required');
    $('#typeProcedure').removeAttr('required');
    $('#numOrd').removeAttr('required');

    $('#formCitationDirect').removeAttr('hidden', true);
    $('#idSaisiPar').attr('required', true);
    $('#recepteurCitation').attr('required', true);
    $('#mentionParticuliere').attr('required', true);
    $('#chefAccusation').attr('required', true);

    $('#formPcpc').attr('hidden', true);
    $('#datePcpc').removeAttr('required');
    $('#reference').removeAttr('required');
    $('#idSaisiPar').removeAttr('required');
    $('#dateProchaineAud').removeAttr('required');
}

function formCitation() {


    $('#formAssignation').attr('hidden', true);
    //$('#numRg').removeAttr('required');
    $('#huissierAssign').removeAttr('required');
    $('#recepteurAss').removeAttr('required');
    $('#dateAssignation').removeAttr('required');
    $('#datePremiereComp').removeAttr('required');
    $('#dateEnrollement').removeAttr('required');
    $('#mentionParticuliereAssign').removeAttr('required');
    $('#pieceAS').removeAttr('required');    
    $('#pieceREQ').removeAttr('required');
    $('#pieceOPP').removeAttr('required'); 

   $('#formRequete').attr('hidden', true);
    //$('#numRgRequete').removeAttr('required');
    $('#dateRequete').removeAttr('required');
    $('#dateArriver').removeAttr('required');
    $('#juriductionPresidentielle').removeAttr('required');


    $('#formOpposition').attr('hidden', true);
    $('#numRgOpp').removeAttr('required');
    $('#idHuissierOpp').removeAttr('required');
    $('#recepteurAssOpp').removeAttr('required');
    $('#datePremiereCompOpp').removeAttr('required');
    $('#dateEnrollementOpp').removeAttr('required');
    $('#dateProchaineAud').removeAttr('required');
    $('#numDecision').removeAttr('required');
    $('#mentionParticuliereOpp').removeAttr('required');

    $('#formCitation').removeAttr('hidden');
    $('#idHuissierCit').attr('required', true);
    $('#dateSignification').attr('required', true);
    $('#personneCharger').attr('required', true);
    $('#numRgCitation').attr('required', true);
    $('#dateCitation').attr('required', true);
    $('#dateAudienceCitation').attr('required', true);
    $('#lieuAudience').attr('required', true);
    $('#pieceCitation').attr('required', true);

    $('#formAutre').attr('hidden', true);
    $('#mention').removeAttr('required');
    $('#valeur').removeAttr('required');
}

function formAutre() {


    $('#formAssignation').attr('hidden', true);
    //$('#numRg').removeAttr('required');
    $('#huissierAssign').removeAttr('required');
    $('#recepteurAss').removeAttr('required');
    $('#dateAssignation').removeAttr('required');
    $('#datePremiereComp').removeAttr('required');
    $('#dateEnrollement').removeAttr('required');
    $('#mentionParticuliereAssign').removeAttr('required');
    $('#pieceAS').removeAttr('required');    
    $('#pieceREQ').removeAttr('required');
    $('#pieceOPP').removeAttr('required'); 

    $('#formRequete').attr('hidden', true);
    //$('#numRgRequete').removeAttr('required');
    $('#dateRequete').removeAttr('required');
    $('#dateArriver').removeAttr('required');
    $('#juriductionPresidentielle').removeAttr('required');


    $('#formOpposition').attr('hidden', true);
    $('#numRgOpp').removeAttr('required');
    $('#idHuissierOpp').removeAttr('required');
    $('#recepteurAssOpp').removeAttr('required');
    $('#datePremiereCompOpp').removeAttr('required');
    $('#dateEnrollementOpp').removeAttr('required');
    $('#dateProchaineAud').removeAttr('required');
    $('#numDecision').removeAttr('required');
    $('#mentionParticuliereOpp').removeAttr('required');

    $('#formCitation').attr('hidden', true);
    $('#idHuissierCit').removeAttr('required');
    $('#dateSignification').removeAttr('required');
    $('#personneCharger').removeAttr('required');
    $('#numRgCitation').removeAttr('required');
    $('#dateCitation').removeAttr('required');
    $('#dateAudienceCitation').removeAttr('required');
    $('#lieuAudience').removeAttr('required');
    $('#pieceCitation').removeAttr('required');

    $('#formAutre').removeAttr('hidden');
    $('#mention').attr('required', true);
    $('#valeur').attr('required', true);
}

function formPcpc() {
    $('#formPvInterogatoire').attr('hidden', true);
    $('#dateAudition').removeAttr('required');
    $('#infractions').removeAttr('required');
    $('#dateAudience').removeAttr('required');


    $('#formRequisitoire').attr('hidden', true);
    $('#chefAccusationReq').removeAttr('required');

    $('#formOrdonnanceRenvoi').attr('hidden', true);
    $('#numOrd').removeAttr('required');
    $('#cabinetIns').removeAttr('required');
    $('#typeProcedure').removeAttr('required');

    $('#formCitationDirect').attr('hidden', true);
    $('#idSaisiPar').removeAttr('required');
    $('#recepteurCitation').removeAttr('required');
    $('#mentionParticuliere').removeAttr('required');
    $('#chefAccusation').removeAttr('required');

    $('#formPcpc').removeAttr('hidden', true);
    $('#datePcpc').attr('required', true);
    $('#reference').attr('required', true);
    $('#dateProchaineAud').attr('required', true);
}


// Appel
function formDeclarationAppel() {
    $('#formDeclarationAppel').removeAttr('hidden');
    //$('#numRg').attr('required', true);
    $('#numJugement').attr('required', true);
    $('#dateAppel').attr('required', true);


    $('#formContredit').attr('hidden', true);
    $('#numConcerner').removeAttr('required');
    $('#numDecision').removeAttr('required');
    $('#dateContredit').removeAttr('required');
    $('#dateDecision').removeAttr('required');


    $('#formAssignationAppel').attr('hidden', true);
    $('#numRgAss').removeAttr('required');
    $('#huissier').removeAttr('required');
    $('#recepteurAss').removeAttr('required');
    $('#dateAssignation').removeAttr('required');
    $('#datePremiereComp').removeAttr('required');
    $('#dateEnrollement').removeAttr('required');
    $('#mentionParticuliere').removeAttr('required');
    $('#pieceAS').removeAttr('required');

    $('#formRequeteAppel').attr('hidden', true);
    //$('#numRgRequete').removeAttr('required');
    $('#dateRequete').removeAttr('required');
    $('#dateArriver').removeAttr('required');
    $('#juriductionPresidentielle').removeAttr('required');
}

function formContredit() {
    $('#formDeclarationAppel').attr('hidden', true);
    //$('#numRG').removeAttr('required');
    $('#numJugement').removeAttr('required');
    $('#dateAppel').removeAttr('required');


    $('#formContredit').removeAttr('hidden');
    $('#numConcerner').attr('required', true);
    $('#numDecision').attr('required', true);
    $('#dateContredit').attr('required', true);
    $('#dateDecision').attr('required', true);


    $('#formAssignationAppel').attr('hidden', true);
    $('#numRgAss').removeAttr('required');
    $('#huissier').removeAttr('required');
    $('#recepteurAss').removeAttr('required');
    $('#dateAssignation').removeAttr('required');
    $('#datePremiereComp').removeAttr('required');
    $('#dateEnrollement').removeAttr('required');
    $('#mentionParticuliere').removeAttr('required');
    $('#pieceAS').removeAttr('required');

    $('#formRequeteAppel').attr('hidden', true);
    //$('#numRgRequete').removeAttr('required');
    $('#dateRequete').removeAttr('required');
    $('#dateArriver').removeAttr('required');
    $('#juriductionPresidentielle').removeAttr('required');
}

function formAssignationAppel() {
    $('#formDeclarationAppel').attr('hidden', true);
   //$('#numRG').removeAttr('required');
    $('#numJugement').removeAttr('required');
    $('#dateAppel').removeAttr('required');


    $('#formContredit').attr('hidden', true);
    $('#numConcerner').removeAttr('required');
    $('#numDecision').removeAttr('required');
    $('#dateContredit').removeAttr('required');
    $('#dateDecision').removeAttr('required');


    $('#formAssignationAppel').removeAttr('hidden');
    $('#numRgAss').attr('required', true);
    $('#huissier').attr('required', true);
    $('#recepteurAss').attr('required', true);
    $('#dateAssignation').attr('required', true);
    $('#datePremiereComp').attr('required', true);
    $('#dateEnrollement').attr('required', true);
    $('#mentionParticuliere').attr('required', true);
    $('#pieceAS').attr('required', true);
    $('#pieceREQ').removeAttr('required');

    $('#formRequeteAppel').attr('hidden', true);
    //$('#numRgRequete').removeAttr('required');
    $('#dateRequete').removeAttr('required');
    $('#dateArriver').removeAttr('required');
    $('#juriductionPresidentielle').removeAttr('required');
}

function formRequeteAppel() {
    $('#formDeclarationAppel').attr('hidden', true);
    //$('#numRG').removeAttr('required');
    $('#numJugement').removeAttr('required');
    $('#dateAppel').removeAttr('required');


    $('#formContredit').attr('hidden', true);
    $('#numConcerner').removeAttr('required');
    $('#numDecision').removeAttr('required');
    $('#dateContredit').removeAttr('required');
    $('#dateDecision').removeAttr('required');


    $('#formAssignationAppel').attr('hidden', true);
    $('#numRgAss').removeAttr('required');
    $('#huissier').removeAttr('required');
    $('#recepteurAss').removeAttr('required');
    $('#dateAssignation').removeAttr('required');
    $('#datePremiereComp').removeAttr('required');
    $('#dateEnrollement').removeAttr('required');
    $('#mentionParticuliere').removeAttr('required');
    $('#pieceAS').removeAttr('required');
    $('#pieceREQ').attr('required', true);

    $('#formRequeteAppel').removeAttr('hidden');
    //$('#numRgRequete').attr('required', true);
    $('#dateRequete').attr('required', true);
    $('#dateArriver').attr('required', true);
    $('#juriductionPresidentielle').attr('required', true);
}


// Condition de saisi au niveau de la citation directe
function saisiPar() {

    var saisiParValue = $('#idSaisiPar').val();

    if (saisiParValue == 'Procureur') {
        $('#huissier').attr('hidden', true);
        $('#dateSignification').attr('hidden', true);
    } else {
        $('#huissier').removeAttr('hidden');
        $('#dateSignification').removeAttr('hidden');
    }
}
</script>

<script>
$(document).ready(function() {
    console.warn = () => {};
    /** Mise en forme des SELECT **/
    LoadSelect2Script(oSelectForm);

    // Si le plugin n'est pas inclus dans la source, on l'intègre et on exécute la fonction passée en callback
    function LoadSelect2Script(callback) {
        if (!$.fn.select2) {
            $.getScript('/public/assets/plugins/select2/select2.full.min.js', callback);
        } else {
            if (callback && typeof(callback) === "function") {
                callback();
            }

        }
    }

    /**
     * @fonction : oSelectForm
     * @void (void) : void
     * @descr : Applique le plugin select2 sur les DOM élément SELECT
     **/
    function oSelectForm() {
        try {
            $("select").style('height:220px;');
            $("select").select2();

        } catch (error) {
            //console.log(error);
        }


    }

    //changement de decision lors du suivi
    $('#decision').on("change", function() {

        var decision = $('#decision').val();

        if (decision == 'renvoi') {
            $('#renvoi').removeAttr('hidden');
            $('#miseDeliberer').attr('hidden', true);
            $('#viderDeliberer').attr('hidden', true);
            $('#autreDecision').attr('hidden', true);

        }
        if (decision == 'miseDeliberer') {
            $('#miseDeliberer').removeAttr('hidden');
            $('#renvoi').attr('hidden', true);
            $('#viderDeliberer').attr('hidden', true);
            $('#autreDecision').attr('hidden', true);

        }
        if (decision == 'viderDeliberer') {
            $('#viderDeliberer').removeAttr('hidden');
            $('#renvoi').attr('hidden', true);
            $('#miseDeliberer').attr('hidden', true);
            $('#autreDecision').attr('hidden', true);
        }
       
        if (decision == 'autre') {
            $('#autreDecision').removeAttr('hidden');
            $('#renvoi').attr('hidden', true);
            $('#miseDeliberer').attr('hidden', true);
            $('#viderDeliberer').attr('hidden', true);

        }

    });
})

// Changement de type tache 
$('#typeTache').on("change", function() {
    var typeTache = $('#typeTache').val();

    if (typeTache == 1) {

        $('.tacheSimpleDate').removeAttr('hidden');
        $('.tacheSimpleDate').removeAttr('hidden');
        $('#descOrdinaire').removeAttr('hidden');
        $('#divNomTache').removeAttr('hidden');
        $('#nomTache').attr('required', true);
        $('#tacheEntreprise').attr('hidden', true);
        $('#divPersonnePoint').removeAttr('hidden');

    }
    if (typeTache == 2) {

        $('#tacheEntreprise').removeAttr('hidden');

        $('#descOrdinaire').attr('hidden', true);
        $('#desc').removeAttr('required');


        $('.tacheSimpleDate').attr('hidden', true);
        $('.tacheConditionnelDate').attr('hidden', true);
        $('#dateDebutTa').removeAttr('required');
        $('#dateFinTa').removeAttr('required');
        $('#dateFinCond1').removeAttr('required');

        $('#nomTache').removeAttr('required');
        $('#divNomTache').attr('hidden', true);


        $('#personnePoint').removeAttr('required');
        $('#divPersonnePoint').attr('hidden', true);

    }
});

// Model de courier depart js
$('#dateProcesVerbal').on("change", function() {
    var dateProcesVerbal = $('#dateProcesVerbal').val();
    const date = new Date(dateProcesVerbal);
    const formattedDate = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;
    $('.dateProcesVerbalSpan').text(`${formattedDate}`);
});

$('#dateCourier').on("change", function() {
    var dateCourier = $('#dateCourier').val();
    const date = new Date(dateCourier);
    const formattedDate = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;
    $('.dateCourierSpan').text(`${formattedDate}`);
});

$('#affaireClient').on("change", function() {


    titre = document.getElementById("affaireClient").options[document
        .getElementById('affaireClient').selectedIndex].text;
    $('.affaireSpan').text(`${titre}`);


});

$('#destinataire').on("keyup", function() {

    var juridiction = $('#destinataire').val();

    $('.destinataireSpan').text(`${juridiction}`);

});

$('#partieAdverse').on("keyup", function() {

    var partieAdverse = $('#partieAdverse').val();

    $('.partieAdverseSpan').text(`${partieAdverse}`);

});
$('#motif').on("keyup", function() {

    var motif = $('#motif').val();

    $('.motifSpan').text(`${motif}`);

});

$('#jugement').on("keyup", function() {

    var motif = $('#jugement').val();

    $('.jugementSpan').text(`${motif}`);

});

$('#courAppel').on("keyup", function() {

    var motif = $('#courAppel').val();

    $('.courAppelSpan').text(`${motif}`);

});

$('#typeModel').on("change", function() {

    var typeModel = $('#typeModel').val();

    if (typeModel == 'aucun') {
        //Div
        $('#partieAdverseDiv').attr('hidden', true);
        $('#appelDiv').attr('hidden', true);
        $('#dateProcesDiv').attr('hidden', true);
        $('#models').attr('hidden', true);

        $('#piece').removeAttr('hidden');
        $('#file').attr('required', true);

        //Champs
        $('#partieAdverse').removeAttr('required');
        $('#motif').removeAttr('required');
        $('#jugement').removeAttr('required');
        $('#courAppel').removeAttr('required');
        $('#dateProcesVerbal').removeAttr('required');

        $('#desc').val('');
    } else {

        $('#piece').attr('hidden', true);
        $('#file').removeAttr('required');

        titre = document.getElementById("typeModel").options[document
            .getElementById('typeModel').selectedIndex].text;

    }

    if (typeModel == 'LT') {

        //Div
        $('#partieAdverseDiv').attr('hidden', true);
        $('#appelDiv').attr('hidden', true);
        $('#dateProcesDiv').attr('hidden', true);
        $('#models').removeAttr('hidden');
        $('#lettreTransmissionForm').removeAttr('hidden');
        $('#lettreConstitutionPersForm').attr('hidden', true);
        $('#lettreConstitutionSocieteForm').attr('hidden', true);
        $('#declarationPersForm').attr('hidden', true);
        $('#declarationSocieteForm').attr('hidden', true);
        $('#ouvertureCompteForm').attr('hidden', true);
        //Champs
        $('#partieAdverse').removeAttr('required');
        $('#motif').removeAttr('required');
        $('#jugement').removeAttr('required');
        $('#courAppel').removeAttr('required');
        $('#dateProcesVerbal').removeAttr('required');
        $('#desc').val('Lettre de transmission APIP');
    }

    if (typeModel == 'LCP') {
        //Div
        $('#partieAdverseDiv').removeAttr('hidden');
        $('#appelDiv').attr('hidden', true);
        $('#dateProcesDiv').attr('hidden', true);
        $('#models').removeAttr('hidden');
        $('#lettreTransmissionForm').attr('hidden', true);
        $('#lettreConstitutionPersForm').removeAttr('hidden');
        $('#lettreConstitutionSocieteForm').attr('hidden', true);
        $('#declarationPersForm').attr('hidden', true);
        $('#declarationSocieteForm').attr('hidden', true);
        $('#ouvertureCompteForm').attr('hidden', true);
        //Champs
        $('#partieAdverse').attr('required', true);
        $('#motif').attr('required', true);
        $('#jugement').removeAttr('required');
        $('#courAppel').removeAttr('required');
        $('#dateProcesVerbal').removeAttr('required');
        $('#desc').val('Lettre de constitution');
    }

    if (typeModel == 'LCS') {
        //Div
        $('#partieAdverseDiv').removeAttr('hidden');
        $('#appelDiv').attr('hidden', true);
        $('#dateProcesDiv').attr('hidden', true);
        $('#models').removeAttr('hidden');
        $('#lettreTransmissionForm').attr('hidden', true);
        $('#lettreConstitutionPersForm').attr('hidden', true);
        $('#lettreConstitutionSocieteForm').removeAttr('hidden');
        $('#declarationPersForm').attr('hidden', true);
        $('#declarationSocieteForm').attr('hidden', true);
        $('#ouvertureCompteForm').attr('hidden', true);
        //Champs
        $('#partieAdverse').attr('required', true);
        $('#motif').attr('required', true);
        $('#jugement').removeAttr('required');
        $('#courAppel').removeAttr('required');
        $('#dateProcesVerbal').removeAttr('required');
        $('#desc').val('Lettre de constitution');
    }

    if (typeModel == 'DAP') {
        //Div
        $('#partieAdverseDiv').attr('hidden', true);
        $('#appelDiv').removeAttr('hidden');
        $('#dateProcesDiv').attr('hidden', true);
        $('#models').removeAttr('hidden');
        $('#lettreTransmissionForm').attr('hidden', true);
        $('#lettreConstitutionPersForm').attr('hidden', true);
        $('#lettreConstitutionSocieteForm').attr('hidden', true);
        $('#declarationPersForm').removeAttr('hidden');
        $('#declarationSocieteForm').attr('hidden', true);
        $('#ouvertureCompteForm').attr('hidden', true);
        //Champs
        $('#partieAdverse').removeAttr('required');
        $('#motif').removeAttr('required');
        $('#jugement').attr('required', true);
        $('#courAppel').attr('required', true);
        $('#dateProcesVerbal').removeAttr('required');
        $('#desc').val('Déclaration d\'appel');
    }

    if (typeModel == 'DAS') {
        //Div
        $('#partieAdverseDiv').attr('hidden', true);
        $('#appelDiv').removeAttr('hidden');
        $('#dateProcesDiv').attr('hidden', true);
        $('#models').removeAttr('hidden');
        $('#lettreTransmissionForm').attr('hidden', true);
        $('#lettreConstitutionPersForm').attr('hidden', true);
        $('#lettreConstitutionSocieteForm').attr('hidden', true);
        $('#declarationPersForm').attr('hidden', true);
        $('#declarationSocieteForm').removeAttr('hidden');
        $('#ouvertureCompteForm').attr('hidden', true);
        //Champs
        $('#partieAdverse').removeAttr('required');
        $('#motif').removeAttr('required');
        $('#jugement').attr('required', true);
        $('#courAppel').attr('required', true);
        $('#dateProcesVerbal').removeAttr('required');
        $('#desc').val('Déclaration d\'appel');
    }

    if (typeModel == 'LDC') {
        //Div
        $('#partieAdverseDiv').attr('hidden', true);
        $('#appelDiv').attr('hidden', true);
        $('#dateProcesDiv').removeAttr('hidden');
        $('#models').removeAttr('hidden');
        $('#lettreTransmissionForm').attr('hidden', true);
        $('#lettreConstitutionPersForm').attr('hidden', true);
        $('#lettreConstitutionSocieteForm').attr('hidden', true);
        $('#declarationPersForm').attr('hidden', true);
        $('#declarationSocieteForm').attr('hidden', true);
        $('#ouvertureCompteForm').removeAttr('hidden');
        //Champs
        $('#partieAdverse').removeAttr('required');
        $('#motif').removeAttr('required');
        $('#jugement').removeAttr('required');
        $('#courAppel').removeAttr('required');
        $('#dateProcesVerbal').attr('required', true);
        $('#desc').val('Lettre de demande d\'ouverture de compte bancaire');
    }


});

// dans la page new level
function natureLevel() {
    $natureLevel = $('#nature').val();

    if ($natureLevel == 'Pénale') {
        $('#formInstruction').removeAttr('hidden');
    } else {
        $('#formInstruction').attr('hidden', true);
    }
}

var i = 0;
$("#dynamic-ar").click(function() {

    ++i;
    $("#dynamicAddRemove").append('<tr><td><input type="text" name="formset[' + i +

        '][designation]" class="form-control" required /></td><td><input type="number" name="formset[' +
        i +
        '][prix]" class="form-control prix" required/></td><td><button type="button" class="btn btn-outline-danger remove-input-field"><i class="fa fa-trash"></i></button></td></tr>'
    );
});

$(document).on('click', '.remove-input-field', function() {
    $(this).parents('tr').remove();
    calculMontant();
});

$("#dynamic-requeteMention").click(function() {

++i;
$("#dynamicAddRemoveRequeteMention").append('<tr><td><input type="text" name="formsetMentionRequete[' + i +

    '][nomRequerent]" class="form-control" /></td><td><input type="text" name="formsetMentionRequete[' +
    i +
    '][adresseRequerent]" class="form-control"/></td><td><input type="text" name="formsetMentionRequete[' +
    i +
    '][formeSocialeRequerent]" class="form-control"/></td><td><button type="button" class="btn btn-outline-danger remove-input-field"><i class="fa fa-trash"></i></button></td></tr>'
);
});

$(document).on('click', '.remove-input-field', function() {
    $(this).parents('tr').remove();
});


$(document).on('keyup', '.prix', function() {

    calculMontant();
});

$(document).on('change', '#selectMonnaie', function() {

    var spans = document.querySelectorAll(".monnaieSpan");
    var selectMonnaie = $('#selectMonnaie').val();

    // Parcourez chaque <span> et changez son contenu
    for (var i = 0; i < spans.length; i++) {
        spans[i].textContent = selectMonnaie;
    }

});

$(document).on('change', '#tva', function() {

    calculMontant();

});

function calculMontant() {

    // Sélectionnez tous les éléments avec la classe "input-somme"
    var prix = document.querySelectorAll(".prix");


    // Initialisez une variable pour stocker la somme
    var valTva = $('#tva').val();
    var ht = 0;
    var tva = 0;
    var ttc = 0;

    // Parcourez tous les éléments et ajoutez leurs valeurs à la somme
    for (var i = 0; i < prix.length; i++) {
        var valeur = parseFloat(prix[i].value); // Convertissez la valeur en nombre (en cas de chaîne)

        if (!isNaN(valeur)) { // Assurez-vous que la valeur est un nombre
            ht += valeur;
        }
    }
    $('#montantHT').val(ht);

    tva = ht * valTva / 100;
    $('#montantTVA').val(tva);

    ttc = tva + ht;
    $('#montantTTC').val(ttc);
}

const euro = new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: 'EUR',
    minimumFractionDigits: 2
});

const usd = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 2
});

//console.log(usd.format(8000));
//console.log(usd.format(25));
//console.log(usd.format(99600023147));


$(document).on('change', '#monnaieParDefaut', function() {

    var monnaieParDefaut = $('#monnaieParDefaut').val();

    $('#m1').val("GNF/" + monnaieParDefaut);
    $('#m2').val("EURO/" + monnaieParDefaut);
    $('#m3').val("USD/" + monnaieParDefaut);
    $('#m4').val("FCFA/" + monnaieParDefaut);


});

$("#dynamic-arRIB").click(function() {

    var i = parseInt($('#valeurI').val());
    ++i;
    $("#dynamicAddRemove").append('<tr><input type="hidden" name="formset[' +
        i +
        '][idCompteBank]" value=' + i + '><td><input type="text" name="formset[' + i +

        '][nomBank]" class="form-control" required /></td><td><input type="text" name="formset[' +
        i +
        '][codeBank]" class="form-control" /></td><td><input type="text" name="formset[' + i +

        '][codeGuichet]" class="form-control"  /></td><td><input type="text" name="formset[' + i +

        '][numCompte]" class="form-control" required /></td><td><input type="text" name="formset[' + i +

        '][cleRib]" class="form-control"  /></td><td><input type="text" name="formset[' + i +

        '][iban]" class="form-control"  /></td><td><input type="text" name="formset[' + i +

        '][codeBic]" class="form-control"  /></td><td><button type="button" class="btn btn-outline-danger remove-input-field-RIB"><i class="fa fa-trash"></i></button></td></tr>'
    );
});

/*

$(document).on('click', '.remove-input-field-RIB', function() {
    $(this).parents('tr').remove();
});
*/


$(document).on('click', '.remove-input-field-RIB', function () {
    var tr = $(this).closest('tr');

    // Marquer pour suppression si un champ "idCompteBank" existe (déjà en base)
    var idHidden = tr.find('input[name*="[idCompteBank]"]');
    if (idHidden.length > 0) {
        var nameAttr = idHidden.attr('name'); // ex: formset[2][idCompteBank]
        var index = nameAttr.match(/formset\[(\d+)\]/)[1];

        // Ajouter un champ _delete à 1
        tr.append('<input type="hidden" name="formset[' + index + '][_delete]" value="1">');

        // Masquer la ligne sans supprimer du DOM
        tr.hide();
    } else {
        // Si ce n’est pas encore enregistré en base (nouvelle ligne), on peut supprimer normalement
        tr.remove();
    }
});



var i = 0;

$("#dynamic-clt-society").click(function() {

    ++i;
    $("#dynamicAddRemove-society").append('<tr><td><input type="text" name="formset[' + i +

        '][prenom]" class="form-control" required /></td><td><input type="text" name="formset[' +
        i +
        '][nom]" class="form-control" /></td><td><input type="text" name="formset[' + i +

        '][poste]" class="form-control"  /></td><td><input type="text" name="formset[' + i +

        '][email]" class="form-control" required /></td><td><input type="text" name="formset[' + i +

        '][telephone]" class="form-control"  /></td><td><button type="button" class="btn btn-outline-danger remove-input-field-clt-society"><i class="fa fa-trash"></i></button></td></tr>'
    );
});


$(document).on('click', '.remove-input-field-clt-society', function() {
    $(this).parents('tr').remove();
});

$("#dynamic-clt-person").click(function() {

++i;
$("#dynamicAddRemove-person").append('<tr><td><input type="text" name="formset[' + i +

    '][prenom]" class="form-control" required /></td><td><input type="text" name="formset[' +
    i +
    '][nom]" class="form-control" /></td><td><input type="text" name="formset[' + i +

    '][poste]" class="form-control"  /></td><td><input type="text" name="formset[' + i +

    '][email]" class="form-control" required /></td><td><input type="text" name="formset[' + i +

    '][telephone]" class="form-control"  /></td><td><button type="button" class="btn btn-outline-danger remove-input-field-clt-person"><i class="fa fa-trash"></i></button></td></tr>'
);
});


$(document).on('click', '.remove-input-field-clt-person', function() {
$(this).parents('tr').remove();
});

var v = 1;

function formsetPiece() {
    ++v;
    $("#dynamicAddRemovePiece").append('<tr><td><input type="file" accept="image/*,.pdf, .doc, docx" name="formsetPiece[' +
        v +
        '][autrePieces]" class="form-control" accept=".pdf"  required /></td><td><button type="button" class="btn btn-outline-danger remove-input-field-piece"><i class="fa fa-trash"></i></button></td></tr>'
    );
}


$(document).on('click', '.remove-input-field-piece', function() {
        $(this).closest('tr').remove();
});

function formsetAutreActe() {
        ++v;
        $("#dynamicAddRemoveActe").append('<tr><td><input type="text" name="formsetAutreActe[' +
            v +
            '][mention]" class="form-control"  required /></td><td><input type="text"  name="formsetAutreActe[' +
            v +
            '][valeur]" class="form-control" required /></td><td><button type="button" class="btn btn-outline-danger remove-input-field-acte"><i class="fa fa-trash"></i></button></td></tr>'
        );
}


$(document).on('click', '.remove-input-field-acte', function() {
        $(this).closest('tr').remove();
});

function disponibilitePiece(){

    var checkbox = $("#pieceDispo");
        if (checkbox.is(':checked')) {
            $('#autrePieces').attr('hidden', true);
            $('#piece').removeAttr('required');
        } else {
            $('#autrePieces').removeAttr('hidden');
            $('#piece').attr('required', true);
        }
}



$(document).on('keyup', '#montantPayer', function() {
    var montantTTC = document.getElementById('montantTTCjs').value;
    var montantPayer = document.getElementById('montantPayer').value;
    var reste = parseFloat(montantTTC) - montantPayer;
    document.getElementById('montantRestant').value = reste;
});

$('#acteDecision').on("change", function() {


    var acteDecision = $('#acteDecision').val();

    if (acteDecision == 'Conclusions') {
        $('#conclusion').removeAttr('hidden');
        $('#invitationAconclure').attr('hidden', true);
        $('#injonctionAconclure').attr('hidden', true);
        $('#pvConstat').attr('hidden', true);
        $('#avenirConstat').attr('hidden', true);
        $('#autreActe').attr('hidden', true);
        $('#conference').attr('hidden', true);
        $('#miseDeliberer').attr('hidden', true);
        $('#delibererProroger').attr('hidden', true);
        $('#Renvoi').attr('hidden', true);
        $('#appelantIntimeConclusion').attr('required', true);
        $('#dateActeConclusion').attr('required', true);
        $('#dateReceptionConclusion').attr('required', true);

        $('#dateActeInvitation').removeAttr('required');
        $('#appelantIntimeInvitation').removeAttr('required');
        $('#dateLimiteInvitation').removeAttr('required');
        $('#PDate').removeAttr('required');
        $('#dateActeInjonction').removeAttr('required');
        $('#appelantIntimeInjonction').removeAttr('required');
        $('#dateLimiteInjonction').removeAttr('required');
        $('#dateActeConstat').removeAttr('required');
        $('#huissierConstat').removeAttr('required');
        $('#dateActeAvenir').removeAttr('required');
        $('#appelantIntimeAvenir').removeAttr('required');
        $('#dateProchaineAudienceAvenir').removeAttr('required');
        $('#dateEtat').removeAttr('required');
        $('#dateConferenceRecu').removeAttr('required');
        $('#dateExpConference').removeAttr('required');
        $('#dateDeliberer').removeAttr('required');
        $('#dateActeProrogé').removeAttr('required');
        $('#dateProrogé').removeAttr('required');
        $('#dateRenvoiAppel').removeAttr('required');
        $('#raisonRenvoi').removeAttr('required');
        $('#autres').removeAttr('required');




    }
    if (acteDecision == 'Invitation à conclure') {

        $('#conclusion').attr('hidden', true);
        $('#invitationAconclure').removeAttr('hidden');
        $('#injonctionAconclure').attr('hidden', true);
        $('#pvConstat').attr('hidden', true);
        $('#avenirConstat').attr('hidden', true);
        $('#autreActe').attr('hidden', true);
        $('#conference').attr('hidden', true);
        $('#miseDeliberer').attr('hidden', true);
        $('#delibererProroger').attr('hidden', true);
        $('#Renvoi').attr('hidden', true);
        $('#dateActeInvitation').attr('required', true);
        $('#appelantIntimeInvitation').attr('required', true);
        $('#dateLimiteInvitation').attr('required', true);

        $('#appelantIntimeConclusion').removeAttr('required');
        $('#dateActeConclusion').removeAttr('required');
        $('#dateReceptionConclusion').removeAttr('required');
        $('#PDate').removeAttr('required');
        $('#dateActeInjonction').removeAttr('required');
        $('#appelantIntimeInjonction').removeAttr('required');
        $('#dateLimiteInjonction').removeAttr('required');
        $('#dateActeConstat').removeAttr('required');
        $('#huissierConstat').removeAttr('required');
        $('#dateActeAvenir').removeAttr('required');
        $('#appelantIntimeAvenir').removeAttr('required');
        $('#dateProchaineAudienceAvenir').removeAttr('required');
        $('#dateEtat').removeAttr('required');
        $('#dateConferenceRecu').removeAttr('required');
        $('#dateExpConference').removeAttr('required');
        $('#dateDeliberer').removeAttr('required');
        $('#dateActeProrogé').removeAttr('required');
        $('#dateProrogé').removeAttr('required');
        $('#dateRenvoiAppel').removeAttr('required');
        $('#raisonRenvoi').removeAttr('required');
        $('#autres').removeAttr('required');



    }
    if (acteDecision == 'Injonction à conclure') {
        $('#conclusion').attr('hidden', true);
        $('#invitationAconclure').attr('hidden', true);
        $('#injonctionAconclure').removeAttr('hidden');
        $('#pvConstat').attr('hidden', true);
        $('#avenirConstat').attr('hidden', true);
        $('#autreActe').attr('hidden', true);
        $('#conference').attr('hidden', true);
        $('#miseDeliberer').attr('hidden', true);
        $('#delibererProroger').attr('hidden', true);
        $('#Renvoi').attr('hidden', true);
        $('#dateActeInjonction').attr('required', true);
        $('#appelantIntimeInjonction').attr('required', true);
        $('#dateLimiteInjonction').attr('required', true);

        $('#appelantIntimeConclusion').removeAttr('required');
        $('#dateActeConclusion').removeAttr('required');
        $('#dateReceptionConclusion').removeAttr('required');
        $('#PDate').removeAttr('required');
        $('#dateActeInvitation').removeAttr('required');
        $('#appelantIntimeInvitation').removeAttr('required');
        $('#dateLimiteInvitation').removeAttr('required');
        $('#dateActeConstat').removeAttr('required');
        $('#huissierConstat').removeAttr('required');
        $('#dateActeAvenir').removeAttr('required');
        $('#appelantIntimeAvenir').removeAttr('required');
        $('#dateProchaineAudienceAvenir').removeAttr('required');
        $('#dateEtat').removeAttr('required');
        $('#dateConferenceRecu').removeAttr('required');
        $('#dateExpConference').removeAttr('required');
        $('#dateDeliberer').removeAttr('required');
        $('#dateActeProrogé').removeAttr('required');
        $('#dateProrogé').removeAttr('required');
        $('#dateRenvoiAppel').removeAttr('required');
        $('#raisonRenvoi').removeAttr('required');
        $('#autres').removeAttr('required');




    }
    if (acteDecision == 'PV de constat de carence') {
        $('#conclusion').attr('hidden', true);
        $('#invitationAconclure').attr('hidden', true);
        $('#injonctionAconclure').attr('hidden', true);
        $('#pvConstat').removeAttr('hidden');
        $('#avenirConstat').attr('hidden', true);
        $('#autreActe').attr('hidden', true);
        $('#conference').attr('hidden', true);
        $('#miseDeliberer').attr('hidden', true);
        $('#delibererProroger').attr('hidden', true);
        $('#Renvoi').attr('hidden', true);
        $('#dateActeConstat').attr('required', true);
        $('#huissierConstat').attr('required', true);

        $('#appelantIntimeConclusion').removeAttr('required');
        $('#dateActeConclusion').removeAttr('required');
        $('#dateReceptionConclusion').removeAttr('required');
        $('#PDate').removeAttr('required');
        $('#dateActeInvitation').removeAttr('required');
        $('#appelantIntimeInvitation').removeAttr('required');
        $('#dateLimiteInvitation').removeAttr('required');
        $('#dateActeInjonction').removeAttr('required');
        $('#appelantIntimeInjonction').removeAttr('required');
        $('#dateLimiteInjonction').removeAttr('required');
        $('#dateActeAvenir').removeAttr('required');
        $('#appelantIntimeAvenir').removeAttr('required');
        $('#dateProchaineAudienceAvenir').removeAttr('required');
        $('#dateEtat').removeAttr('required');
        $('#dateConferenceRecu').removeAttr('required');
        $('#dateExpConference').removeAttr('required');
        $('#dateDeliberer').removeAttr('required');
        $('#dateActeProrogé').removeAttr('required');
        $('#dateProrogé').removeAttr('required');
        $('#dateRenvoiAppel').removeAttr('required');
        $('#raisonRenvoi').removeAttr('required');
        $('#autres').removeAttr('required');




    }

    if (acteDecision == "Avenir d'audience") {
        $('#conclusion').attr('hidden', true);
        $('#invitationAconclure').attr('hidden', true);
        $('#injonctionAconclure').attr('hidden', true);
        $('#pvConstat').attr('hidden', true);
        $('#avenirConstat').removeAttr('hidden');
        $('#autreActe').attr('hidden', true);
        $('#conference').attr('hidden', true);
        $('#miseDeliberer').attr('hidden', true);
        $('#delibererProroger').attr('hidden', true);
        $('#Renvoi').attr('hidden', true);
        $('#dateActeAvenir').attr('required', true);
        $('#appelantIntimeAvenir').attr('required', true);
        $('#dateProchaineAudienceAvenir').attr('required', true);

        $('#appelantIntimeConclusion').removeAttr('required');
        $('#dateActeConclusion').removeAttr('required');
        $('#dateReceptionConclusion').removeAttr('required');
        $('#PDate').removeAttr('required');
        $('#dateActeInvitation').removeAttr('required');
        $('#appelantIntimeInvitation').removeAttr('required');
        $('#dateLimiteInvitation').removeAttr('required');
        $('#dateActeInjonction').removeAttr('required');
        $('#appelantIntimeInjonction').removeAttr('required');
        $('#dateLimiteInjonction').removeAttr('required');
        $('#dateActeConstat').removeAttr('required');
        $('#huissierConstat').removeAttr('required');
        $('#dateEtat').removeAttr('required');
        $('#dateConferenceRecu').removeAttr('required');
        $('#dateExpConference').removeAttr('required');
        $('#dateDeliberer').removeAttr('required');
        $('#dateActeProrogé').removeAttr('required');
        $('#dateProrogé').removeAttr('required');
        $('#dateRenvoiAppel').removeAttr('required');
        $('#raisonRenvoi').removeAttr('required');
        $('#autres').removeAttr('required');



    }
    if (acteDecision == 'Conférence de mise en état/cloture') {
        $('#conference').removeAttr('hidden');
        $('#miseDeliberer').attr('hidden', true);
        $('#conclusion').attr('hidden', true);
        $('#invitationAconclure').attr('hidden', true);
        $('#injonctionAconclure').attr('hidden', true);
        $('#pvConstat').attr('hidden', true);
        $('#avenirConstat').attr('hidden', true);
        $('#delibererProroger').attr('hidden', true);
        $('#viderDeliberer').attr('hidden', true);
        $('#autreActe').attr('hidden', true);
        $('#miseDeliberer').attr('hidden', true);
        $('#delibererProroger').attr('hidden', true);
        $('#Renvoi').attr('hidden', true);
        $('#dateEtat').attr('required', true);
        $('#dateConferenceRecu').attr('required', true);
        $('#dateExpConference').attr('required', true);

        $('#appelantIntimeConclusion').removeAttr('required');
        $('#dateActeConclusion').removeAttr('required');
        $('#dateReceptionConclusion').removeAttr('required');
        $('#PDate').removeAttr('required');
        $('#dateActeInvitation').removeAttr('required');
        $('#appelantIntimeInvitation').removeAttr('required');
        $('#dateLimiteInvitation').removeAttr('required');
        $('#dateActeInjonction').removeAttr('required');
        $('#appelantIntimeInjonction').removeAttr('required');
        $('#dateLimiteInjonction').removeAttr('required');
        $('#dateActeConstat').removeAttr('required');
        $('#huissierConstat').removeAttr('required');
        $('#dateActeAvenir').removeAttr('required');
        $('#appelantIntimeAvenir').removeAttr('required');
        $('#dateProchaineAudienceAvenir').removeAttr('required');
        $('#dateDeliberer').removeAttr('required');
        $('#dateActeProrogé').removeAttr('required');
        $('#dateProrogé').removeAttr('required');
        $('#dateRenvoiAppel').removeAttr('required');
        $('#raisonRenvoi').removeAttr('required');
        $('#autres').removeAttr('required');

    }
    if (acteDecision == 'Mise en délibéré') {
        $('#miseDeliberer').removeAttr('hidden');
        $('#conclusion').attr('hidden', true);
        $('#invitationAconclure').attr('hidden', true);
        $('#injonctionAconclure').attr('hidden', true);
        $('#pvConstat').attr('hidden', true);
        $('#avenirConstat').attr('hidden', true);
        $('#delibererProroger').attr('hidden', true);
        $('#viderDeliberer').attr('hidden', true);
        $('#autreActe').attr('hidden', true);
        $('#conference').attr('hidden', true);
        $('#delibererProroger').attr('hidden', true);
        $('#Renvoi').attr('hidden', true);
        $('#dateDeliberer').attr('required', true);


        $('#appelantIntimeConclusion').removeAttr('required');
        $('#dateActeConclusion').removeAttr('required');
        $('#dateReceptionConclusion').removeAttr('required');
        $('#PDate').removeAttr('required');
        $('#dateActeInvitation').removeAttr('required');
        $('#appelantIntimeInvitation').removeAttr('required');
        $('#dateLimiteInvitation').removeAttr('required');
        $('#dateActeInjonction').removeAttr('required');
        $('#appelantIntimeInjonction').removeAttr('required');
        $('#dateLimiteInjonction').removeAttr('required');
        $('#dateActeConstat').removeAttr('required');
        $('#huissierConstat').removeAttr('required');
        $('#dateActeAvenir').removeAttr('required');
        $('#appelantIntimeAvenir').removeAttr('required');
        $('#dateProchaineAudienceAvenir').removeAttr('required');
        $('#dateEtat').removeAttr('required');
        $('#dateConferenceRecu').removeAttr('required');
        $('#dateExpConference').removeAttr('required');
        $('#dateActeProrogé').removeAttr('required');
        $('#dateProrogé').removeAttr('required');
        $('#dateRenvoiAppel').removeAttr('required');
        $('#raisonRenvoi').removeAttr('required');
        $('#autres').removeAttr('required');




    }
    if (acteDecision == 'Délibéré prorogé') {
        $('#conclusion').attr('hidden', true);
        $('#invitationAconclure').attr('hidden', true);
        $('#injonctionAconclure').attr('hidden', true);
        $('#pvConstat').attr('hidden', true);
        $('#avenirConstat').attr('hidden', true);
        $('#miseDeliberer').attr('hidden', true);
        $('#delibererProroger').removeAttr('hidden');
        $('#viderDeliberer').attr('hidden', true);
        $('#autreActe').attr('hidden', true);
        $('#conference').attr('hidden', true);
        $('#miseDeliberer').attr('hidden', true);
        $('#Renvoi').attr('hidden', true);
        $('#dateActeProrogé').attr('required', true);
        $('#dateProrogé').attr('required', true);

        $('#appelantIntimeConclusion').removeAttr('required');
        $('#dateActeConclusion').removeAttr('required');
        $('#dateReceptionConclusion').removeAttr('required');
        $('#PDate').removeAttr('required');
        $('#dateActeInvitation').removeAttr('required');
        $('#appelantIntimeInvitation').removeAttr('required');
        $('#dateLimiteInvitation').removeAttr('required');
        $('#dateActeInjonction').removeAttr('required');
        $('#appelantIntimeInjonction').removeAttr('required');
        $('#dateLimiteInjonction').removeAttr('required');
        $('#dateActeConstat').removeAttr('required');
        $('#huissierConstat').removeAttr('required');
        $('#dateActeAvenir').removeAttr('required');
        $('#appelantIntimeAvenir').removeAttr('required');
        $('#dateProchaineAudienceAvenir').removeAttr('required');
        $('#dateEtat').removeAttr('required');
        $('#dateConferenceRecu').removeAttr('required');
        $('#dateExpConference').removeAttr('required');
        $('#dateDeliberer').removeAttr('required');
        $('#dateRenvoiAppel').removeAttr('required');
        $('#raisonRenvoi').removeAttr('required');
        $('#autres').removeAttr('required');





    }
    if (acteDecision == 'Renvoi') {
        $('#conclusion').attr('hidden', true);
        $('#invitationAconclure').attr('hidden', true);
        $('#injonctionAconclure').attr('hidden', true);
        $('#pvConstat').attr('hidden', true);
        $('#avenirConstat').attr('hidden', true);
        $('#miseDeliberer').attr('hidden', true);
        $('#delibererProroger').attr('hidden', true);
        $('#Renvoi').removeAttr('hidden');
        $('#viderDeliberer').removeAttr('hidden');
        $('#autreActe').attr('hidden', true);
        $('#conference').attr('hidden', true);
        $('#miseDeliberer').attr('hidden', true);
        $('#delibererProroger').attr('hidden', true);
        $('#dateRenvoiAppel').attr('required', true);
        $('#raisonRenvoi').attr('required', true);

        $('#appelantIntimeConclusion').removeAttr('required');
        $('#dateActeConclusion').removeAttr('required');
        $('#dateReceptionConclusion').removeAttr('required');
        $('#PDate').removeAttr('required');
        $('#dateActeInvitation').removeAttr('required');
        $('#appelantIntimeInvitation').removeAttr('required');
        $('#dateLimiteInvitation').removeAttr('required');
        $('#dateActeInjonction').removeAttr('required');
        $('#appelantIntimeInjonction').removeAttr('required');
        $('#dateLimiteInjonction').removeAttr('required');
        $('#dateActeConstat').removeAttr('required');
        $('#huissierConstat').removeAttr('required');
        $('#dateActeAvenir').removeAttr('required');
        $('#appelantIntimeAvenir').removeAttr('required');
        $('#dateProchaineAudienceAvenir').removeAttr('required');
        $('#dateEtat').removeAttr('required');
        $('#dateConferenceRecu').removeAttr('required');
        $('#dateExpConference').removeAttr('required');
        $('#dateDeliberer').removeAttr('required');
        $('#dateActeProrogé').removeAttr('required');
        $('#dateProrogé').removeAttr('required');
        $('#autres').removeAttr('required');





    }
    if (acteDecision == 'Autre') {
        $('#conclusion').attr('hidden', true);
        $('#invitationAconclure').attr('hidden', true);
        $('#injonctionAconclure').attr('hidden', true);
        $('#pvConstat').attr('hidden', true);
        $('#avenirConstat').attr('hidden', true);
        $('#autreActe').removeAttr('hidden');

        $('#conference').attr('hidden', true);
        $('#miseDeliberer').attr('hidden', true);
        $('#delibererProroger').attr('hidden', true);
        $('#Renvoi').attr('hidden', true);
        $('#autres').removeAttr('hidden');
        $('#autres').attr('required', true);

        $('#appelantIntimeConclusion').removeAttr('required');
        $('#dateActeConclusion').removeAttr('required');
        $('#dateReceptionConclusion').removeAttr('required');
        $('#PDate').removeAttr('required');
        $('#dateActeInvitation').removeAttr('required');
        $('#appelantIntimeInvitation').removeAttr('required');
        $('#dateLimiteInvitation').removeAttr('required');
        $('#dateActeInjonction').removeAttr('required');
        $('#appelantIntimeInjonction').removeAttr('required');
        $('#dateLimiteInjonction').removeAttr('required');
        $('#dateActeConstat').removeAttr('required');
        $('#huissierConstat').removeAttr('required');
        $('#dateActeAvenir').removeAttr('required');
        $('#appelantIntimeAvenir').removeAttr('required');
        $('#dateProchaineAudienceAvenir').removeAttr('required');
        $('#dateEtat').removeAttr('required');
        $('#dateConferenceRecu').removeAttr('required');
        $('#dateExpConference').removeAttr('required');
        $('#dateDeliberer').removeAttr('required');
        $('#dateActeProrogé').removeAttr('required');
        $('#dateProrogé').removeAttr('required');
        $('#dateRenvoiAppel').removeAttr('required');
        $('#raisonRenvoi').removeAttr('required');





    }

});

$('#role').on("change", function() {

    var role = $('#role').val();

    if (role == 'Client') {

        $('#divMatricule').attr('hidden', true);
        $('#getMatricule').removeAttr('required');

        $('#identifiantClient').removeAttr('hidden');
        $('#username').attr('required', true);
        $('#email').attr('required', true);
        $('#idClient').attr('required', true);
        $('#initial').attr('required', true);

    }else if(role == 'Administrateur'){
        $('#divMatricule').attr('hidden', true);
        $('#divClient').attr('hidden', true);
        $('#getMatricule').removeAttr('required');

        $('#identifiantClient').removeAttr('hidden');
        $('#username').attr('required', true);
        $('#email').attr('required', true);
        $('#idClient').removeAttr('required');
        $('#initial').attr('required', true);
    } else {

        $('#divMatricule').removeAttr('hidden');
        $('#getMatricule').attr('required', true);

        $('#identifiantClient').attr('hidden', true);
        $('#username').removeAttr('required');
        $('#email').removeAttr('required');
        $('#idClient').removeAttr('required');
        $('#initial').removeAttr('required');

    }

});

$('.dateProchaine').on("change", function() {
    var dateProchaine =$('.dateProchaine').val();
    $('.dateRecep').val(dateProchaine);
});

function fechAClientExist(event) {
    event.preventDefault(); // ⛔ empêche le submit auto

    var denomination = $('#inputDenomination').val().trim();
    var form = document.getElementById('clientMoral');

    $.ajax({
        type: "GET",
        url: "/fetch-clientName/" + encodeURIComponent(denomination),
        dataType: "json",
        success: function (response) {

            if (response.client.length === 0) {

                if (form.checkValidity()) {
                    form.submit(); // ✅ submit manuel
                } else {
                    form.reportValidity(); // ✅ message HTML5 natif
                }

            } else {
                $('#confirmClient').modal('show');
            }
        },
        error: function () {
            alert("Erreur lors de la vérification du client.");
        }
    });
}


function fechAClientExist2(event) {
    event.preventDefault(); // ⛔ empêche le submit automatique

    var prenom = $('#inputPrenom').val().trim();
    var nom = $('#inputNom').val().trim();
    var form = document.getElementById('clientPhysique');

    $.ajax({
        type: "GET",
        url: "/fetch-clientName/" + encodeURIComponent(prenom) + "/" + encodeURIComponent(nom),
        dataType: "json",
        success: function (response) {
            if (response.client.length === 0) {

                if (form.checkValidity()) {
                    form.submit(); // ✅ submit contrôlé
                } else {
                    form.reportValidity(); // ✅ affiche les erreurs HTML5
                }

            } else {
                $('#confirmClient2').modal('show');
            }
        },
        error: function () {
            alert("Erreur lors de la vérification du client.");
        }
    });
}


function audJonction() {

    var idJuridiction = $('#idJuridiction').val();
    var niveauProcedural = $('#niveauProcedural').val();

    $.ajax({
        type: "GET",
        url: `/fetch-audienceJonction/${idJuridiction}`,
        dataType: "json",
        success: function(response) {
            $('#selectJonction').html("");

            $.each(response.audJonctions, function(key, value) {
                $('#selectJonction').append(
                    `<option value=${value.idAudience}> Audience n°${value.idAudience} - ${value.objet}</option>`)
            });


        },
        error: function(jqXHR, textStatus, errorThrown) {
            //console.log(`JQHR ${jqXHR} \n status: ${textStatus}\n error: ${errorThrown}`);
        }
    });
};
console.clear();

</script>

<script>

    function fetchAffaireCouriers(idClient) {
        var currentSlug = $('#slugCourier').val();
        if (!idClient) return;

        $.ajax({
            type: "GET",
            url: `/fetch-affaire-couriers/${idClient}`,
            data: { slugCourier: currentSlug },
            dataType: "json",
            success: function(response) {
                const $affaireSelect = $('#affaireClient-req');
                const $courrierArriverSelect = $('#courrierArriverSelect');
                const $courrierDepartSelect = $('#courrierDepartSelect');
                const $affaireName = $('#selectedAffaireName');
                const slugCourier = currentSlug || '';

                // Reset Select2 client si initialisés
                if ($.fn.select2) {
                    [$affaireSelect, $courrierArriverSelect, $courrierDepartSelect].forEach($select => {
                        if ($select.hasClass("select2-hidden-accessible")) $select.select2('destroy');
                    });
                }

                // Vider uniquement les selects client
                $affaireSelect.empty();
                $courrierArriverSelect.empty();
                $courrierDepartSelect.empty();
                $affaireName.addClass('d-none').text('');

                if (Array.isArray(response.affaires) && response.affaires.length > 0) {
                    $('#affaireContent-req').removeClass('d-none');

                    const courrierArriversParAffaire = {};
                    const courrierDepartsParAffaire = {};
                    const nomAffaireParId = {};

                    response.affaires.forEach(item => {
                        const affaire = item.affaire || {};
                        const arrivers = Array.isArray(item.couriers_arrivers) ? item.couriers_arrivers : [];
                        const departs = Array.isArray(item.couriers_departs) ? item.couriers_departs : [];

                        if (!affaire.idAffaire) return;

                        $affaireSelect.append(
                            $('<option></option>').val(affaire.idAffaire).text(affaire.nomAffaire || '')
                        );

                        // Exclure le courrier en cours
                        courrierArriversParAffaire[affaire.idAffaire] = arrivers.filter(c => c && c.slug && c.slug !== slugCourier);
                        courrierDepartsParAffaire[affaire.idAffaire] = departs.filter(c => c && c.slug && c.slug !== slugCourier);
                        nomAffaireParId[affaire.idAffaire] = affaire.nomAffaire || '';
                    });

                    $affaireSelect.select2();

                    $affaireSelect.off('change').on('change', function () {
                        const selectedId = parseInt($(this).val(), 10); // <-- conversion en nombre
                        const nomAffaire = nomAffaireParId[selectedId] || '';
                        const courriersArrivers = courrierArriversParAffaire[selectedId] || [];
                        const courriersDeparts = courrierDepartsParAffaire[selectedId] || [];

                        $affaireName.toggleClass('d-none', !nomAffaire).text(nomAffaire ? ` ${nomAffaire}` : '');

                        $courrierArriverSelect.empty();
                        $courrierDepartSelect.empty();

                        // Pour les courriers arrivés
                        $courrierArriverSelect.empty();
                        $courrierArriverSelect.append('<option value=""></option>'); // <-- option vide

                        if (courriersArrivers.length) {
                            console.log("Courriers arrivés:", courriersArrivers);
                            courriersArrivers.forEach(c => {
                                if (c) $courrierArriverSelect.append(
                                    $('<option></option>').val(c.slug || '').text(`${c.idClient || ''} > ${c.prenom || ''} ${c.nom || ''}  ${c.denomination || ''} > ${c.idAffaire || ''}  ${c.nomAffaire || ''}`)
                                );
                            });
                        } else {
                            console.log("Aucun courrier arrivé");
                            $courrierArriverSelect.append('<option disabled>Aucun courrier arrivé</option>');
                        }

                        // Pour les courriers départs
                        $courrierDepartSelect.empty();
                        $courrierDepartSelect.append('<option value=""></option>'); // <-- option vide

                        if (courriersDeparts.length) {
                            console.log("Courriers départs:", courriersDeparts);
                            courriersDeparts.forEach(c => {
                                if (c) $courrierDepartSelect.append(
                                    $('<option></option>').val(c.slug || '').text(`${c.idClient || ''} > ${c.prenom || ''} ${c.nom || ''} ${c.denomination || ''} > ${c.idAffaire || ''}  ${c.nomAffaire || ''}`)
                                );
                            });
                        } else {
                            console.log("Aucun courrier départ");
                            $courrierDepartSelect.append('<option disabled>Aucun courrier départ</option>');
                        }


                        $courrierArriverSelect.select2();
                        $courrierDepartSelect.select2();
                    });

                    // Pour que le premier chargement affiche déjà les courriers de l'affaire sélectionnée
                    $affaireSelect.trigger('change');


                } else $('#affaireContent-req').addClass('d-none');

                // **Ne rien toucher aux selects du cabinet ici**
            },
            error: function(xhr) {
                console.error("Erreur AJAX :", xhr.responseText);
                alert("Erreur lors du chargement des données.");
            }
        });
    }

</script>

<script>
    function confirmDelete(url) {
        Swal.fire({
            title: 'Confirmation de suppression',
            html: `
                <strong>Êtes-vous sûr de vouloir supprimer ?&nbsp;</strong><br>
                <small>Cette action est <span style="color:red;">irréversible</span>.</small>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-trash"></i> Supprimer',
            cancelButtonText: '<i class="fa fa-times" style="color:white; margin-right:5px;"></i> Annuler',
            confirmButtonColor: '#d33',    // Rouge
            cancelButtonColor: '#007bff',  // Bleu
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Suppression en cours...',
                    text: 'Veuillez patienter.',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                // Redirection après un court délai pour montrer l'effet
                setTimeout(() => {
                    window.location.href = url;
                }, 800);
            }
        });
    }


    var monSwitchButton = document.getElementById("infowitch");
    const elements = document.querySelectorAll(".infoPrive");

    $('#infowitch').on('change', function () {
            if (this.checked) {
                // Masquer les données
                elements.forEach(el => el.classList.remove('revealed'));
            } else {
                // Afficher les données
                elements.forEach(el => el.classList.add('revealed'));
            }
    });

</script>