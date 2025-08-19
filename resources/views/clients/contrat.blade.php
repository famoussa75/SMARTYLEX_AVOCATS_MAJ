@extends('layouts.base')
@section('title', 'Contrat du personnel')
@section('content')
<div class="container-fluid">
    <div class="row page-breadcrumbs">
        <div class="col-md-5 align-self-center">

            <p>
            <h4>{{ $contrat[0]->prenomEtNom }}<br></h4>
            <span>Fonction : {{ $contrat[0]->fonction }}<br></span>
            <span>Durée de contrat : {{ $contrat[0]->dureeContrat }}<br></span>
            <span>Téléphone : {{ $contrat[0]->telephone }}<br></span>
            <span>Residence : {{ $contrat[0]->residence }}<br></span>
            </p>

        </div>

    </div>



    <div class="card padd-15 col-md-12 col-sm-12">
        @if($contrat[0]->dureeContrat=='Indéterminé')
        <div class="container"
            style="overflow-y:auto; overflow-x:hidden; height:833px;background-color:whitesmoke;padding-top:20px">
            <img src="{{URL::to('/')}}/{{ $contrat[0]->logo }}" alt="" style="height: 80px;margin-bottom:20px">
            <div class="col-md-12" style="border: 1px solid;text-align:center;padding-top:10px; margin-bottom:50px">
                <h4>CONTRAT DE TRAVAIL</h4>
                <h4>À DURÉE INDÉTERMINÉE</h4>
            </div>

            <div class="col-md-12">
                <h5><b style="text-decoration: underline black;">Entre les sousignés :</b></h5>
                <p>La société {{ $contrat[0]->denomination }} au Capital Social de {{ $contrat[0]->capitalSocial }} GNF
                    immatriculée au RCCM sous le numéro {{ $contrat[0]->rccm }}, ayant son siège social sis à
                    {{ $contrat[0]->adresseEntreprise }}, représentée par son dirigent légal, ci-après désignée
                    <b>‘’Employeur’’</b></p>
                <p style="text-align: right;"><b>D'une part</b></p>
                <p style="text-align: left;"><b>Et</b></p>
                <p>{{ $contrat[0]->prefix }} {{ $contrat[0]->prenomEtNom }}, citoyen de nationalité
                    {{ $contrat[0]->nationalite }} né le {{ date('d-m-Y', strtotime($contrat[0]->dateNaissance)) }} à
                    {{ $contrat[0]->lieuNaissance }}, ayant élu domicile aux fins des présentes au siège social de
                    l’Employeur, titulaire d’un {{ $contrat[0]->naturePiece }} N°{{ $contrat[0]->numPiece }} valable
                    jusqu’au {{ date('d-m-Y', strtotime($contrat[0]->dateExPiece)) }} ci-après « <b>Employé</b> » ;</p>
                <p>Lequel déclare être libre de tout engagement autre que celui prévu dans le présent contrat ;</p>
                <p style="text-align: right;"><b> D’autre part </b></p>
                <p>L’Employeur et l’Employé, étant désignés collectivement les « Parties » et individuellement la «
                    Partie » ;</p>
                <h4 style="text-decoration: underline black;text-align:center;margin-top:50px">Il EST CONVENU ET ARRÊTÉ
                    CE QUI SUIT :</h4>
                <p>Le présent contrat est régi par les dispositions de la loi N°L/2014/072/CNT du 10 janvier 2014
                    portant Code du Travail de la République de Guinée (ci-après, « Code du Travail ») et les textes
                    pris en vue de son application ainsi que le règlement intérieur de la COMPAGNIE.</p>
                <h4>ARTICLE 1 : ENGAGEMENT</h4>
                <p>L’Employé est engagé par l’Employeur à compter du
                    {{ date('d-m-Y', strtotime($contrat[0]->dateEmbauche)) }}, sous réserve (i) qu’il soit déclaré apte
                    à l’issue d’un examen médical organisé par l’Employeur dans les plus brefs délais et compte tenu des
                    contraintes liées à la maladie du coronavirus 2019 (Covid 19) et (ii) qu’il fournisse dans le délai
                    imparti tous les documents demandés en vue de l’embauche.
                    Il reste entendu que l’Employé est tenu de se soumettre à l’examen médical et que toute
                    communication par lui d’un document dont le caractère faux est découvert par l’Employeur après
                    l’embauche, constitue une faute grave au sens du présent contrat et justifie de ce fait une
                    cessation immédiate du lien de travail sans indemnité ni préavis.</p>
                <p>L’Employé déclare être libre de tout engagement, et s’oblige :</p>
                <ul>
                    <li>●&nbsp;&nbsp;À effectuer loyalement en toutes circonstances, les missions qui lui seront
                        confiées par l’Employeur et/ou ses représentants ;</li>
                    <li>●&nbsp;&nbsp;À respecter la discipline et les directives de ses supérieurs hiérarchiques ;</li>
                    <li>●&nbsp;&nbsp;À observer rigoureusement l’ensemble des règles et usages en vigueur au sein de
                        l’entreprise.</li>
                </ul>
                <p>L’Employé consent à ce que l’Employeur utilise, traite ou stocke des données personnelles le
                    concernant, y compris des données sur la santé et la sécurité au travail, pour satisfaire aux
                    exigences légales ainsi que dans le cadre de la conduite des affaires de l’Employeur.</p>
                <p>En outre, l’Employé s’engage expressément à adhérer et respecter le Code de conduite et le Règlement
                    Intérieur mis en place par l’Employeur.</p>
                <p>L’Employé est tenu de connaître l’intégralité de la teneur desdits documents dont une copie de chaque
                    sera tenue à sa disposition par l’Employeur à partir de la date d’embauche.</p>
                <h4>ARTICLE 2 : DUREE DU CONTRAT ET PERIODE D’ESSAI</h4>
                <p>Le présent Contrat est conclu pour une durée indéterminée. </p>
                <p>La prise de fonction du salarié débutera par une période d’essai de
                    {{ $contrat[0]->dureePeriodeEssai }}. Chaque partie sera libre de mettre un terme au contrat durant
                    cette période, sans versement d’indemnités, en respectant le délai de préavis.</p>
                <h4>ARTICLE 3 : FONCTION ET RESPONSABILITÉS</h4>
                <p>L’Employé est engagé pour occuper le poste de Gérant.</p>
                <p>À ce titre, il effectuera toutes les tâches qui sont rattachées à ce poste de gérant dans le cadre de
                    sa fonction.</p>
                <h4>ARTICLE 4 : LIEU D’EMPLOI - MOBILITÉ</h4>
                <p>L’Employé exercera ses fonctions à Conakry. Toutefois, selon les besoins de la société, il pourrait
                    être affecté en tout autre lieu du territoire de la République de Guinée.</p>
                <p>L’Employé pourra en outre être amené, en cas de nécessité pour la société, à effectuer des
                    déplacements ponctuels à l’étranger ou à l’intérieur du pays ne nécessitant pas le changement de sa
                    résidence habituelle. </p>
                <h4>ARTICLE 5 : DUREE DU TRAVAIL</h4>
                <p>Le présent contrat de travail est soumis au régime de quarante (40) heures de travail par semaine à
                    raison de huit (08) heures de travail par jour.
                    Le Code du travail prévoie la possibilité de réaliser des heures supplémentaires.
                </p>
                <h4>ARTICLE 6 : RÉMUNÉRATION</h4>
                <p>En contrepartie de son activité professionnelle, l’employé percevra un salaire mensuel composé comme
                    suit :</p>
                <ul>
                    <li>- salaire de base : GNF {{ $contrat[0]->salaireBase }}</li>
                    <li>- prime de logement : GNF {{ $contrat[0]->primePanier }}</li>
                    <li>- prime de transport : GNF {{ $contrat[0]->primeTransport }}</li>
                    <li>- salaire brut : GNF {{ $contrat[0]->salaireBrut }}</li>
                </ul>
                <p>pour un salaire net de ...... francs guinéens, versé le dernier jour du mois.</p>
                <h4>ARTICLE 7 : CONGÉS</h4>
                <p>L’employé jouira d’un droit aux congés à raison de 2,5 jours ouvrables par mois de travail effectif.
                </p>
                <p>La période de ce congé sera fixée compte tenu des nécessités du service et devra faire l’objet d’une
                    demande de l’Employé et d’un accord écrit de l’Employeur.</p>
                <h4>ARTICLE 8 : AVANTAGES SOCIAUX</h4>
                <p>L’employé bénéficiera du régime d’assurances sociales prévu par la réglementation en vigueur en
                    République de Guinée (Soins médicaux, accident de travail, maladie professionnelle, prestations
                    familiales, retraite).</p>
                <p>Il sera immatriculé à la Caisse nationale de sécurité sociale (CNSS).</p>
                <h4>ARTICLE 9 : EXÉCUTION DU CONTRAT ET EXCLUSIVITÉ</h4>
                <p>L’employé s’engage à observer toutes les instructions et consignes particulières de travail ayant
                    trait à sa fonction. Il s’engage également à consacrer tout son temps, toute son activité et toutes
                    ses connaissances à l’exercice de ses fonctions et à ne s’occuper exclusivement, pendant la durée du
                    présent contrat, que des activités de l’Employeur, s’interdisant formellement de s’intéresser
                    directement ou indirectement à d’autres affaires, sauf accord exprès et préalable de l’employeur.
                </p>
                <h4>ARTICLE 10 : CLAUSE DE CONFIDENTIALITÉ</h4>
                <p>L’employé s’engage pendant la durée de son contrat de travail, et après sa rupture à ne pas divulguer
                    des informations confidentielles sur la société, qu’elles soient en rapport ou non avec sa fonction.
                    Et ceci par quelque moyen que ce soit : oral, verbal, informatique, écrit… et que ce soit à
                    l’intérieur ou à l’extérieur de l’entreprise.</p>
                <h4>ARTICLE 11 : RUPTURE DU CONTRAT</h4>
                <p>Le présent contrat peut être rompu, dans les conditions prévues par la loi :</p>
                <ul>
                    <li>1. D’un commun accord entre les Parties ;</li>
                    <li>2. En cas de faute grave de l’Employé ou de force majeure. Est considéré comme cas de force
                        majeure, tout événement imprévisible, irrésistible et extérieur à la Partie qui l’invoque et
                        dont la survenance empêche l’exécution totale de ses obligations ; </li>
                    <li>3. En cas de cessation d'activité de l'Employeur.</li>
                </ul>
                <h4>ARTICLE 12 : REGLEMENT DES DIFFERENDS</h4>
                <p>Les Parties s’obligent à rechercher une solution amiable à tout différend résultant de
                    l'interprétation ou de l'exécution du présent contrat de travail, dans un délai de trente (30) jours
                    à compter de la réception par l’une d’entre elles de la demande de règlement amiable adressée par
                    l’autre. </p>
                <p>En cas d’échec du règlement amiable ou à l’expiration du délai susmentionné de trente (30) jours,
                    chacune des Parties pourra, sauf accord contraire, porter le différend devant la juridiction
                    territorialement compétente en matière sociale, conformément aux articles 520.1 et suivants du Code
                    du Travail.</p>
                <p style="text-align: right;">{{ $contrat[0]->lieuSignature }}, le
                    {{ date('d-m-Y', strtotime($contrat[0]->dateSignatureContrat)) }}</p>
                <p style="text-align: right;">Fait en deux (02) exemplaires originaux</p>
                <div class="row col-md-12" style="margin-top: 50px;text-align:center">
                    <div class="col-md-6">
                        <h4>L’EMPLOYEUR</h4>
                        <h5>LA SOCIETE {{ $contrat[0]->denomination }} </h5>
                    </div>
                    <div class="col-md-6">
                        <h4>L’EMPLOYE</h4>
                        <h5>{{ $contrat[0]->prefix }} {{ $contrat[0]->prenomEtNom }}</h5>
                    </div>
                </div>

            </div>

        </div>
        @else
        <div class="container"
            style="overflow-y:auto; overflow-x:hidden; height:833px;background-color:whitesmoke;padding-top:20px">
            <img src="{{URL::to('/')}}/{{ $contrat[0]->logo }}" alt="" style="height: 80px;margin-bottom:20px">
            <div class="col-md-12" style="border: 1px solid;text-align:center;padding-top:10px; margin-bottom:50px">
                <h4>CONTRAT DE TRAVAIL</h4>
                <h4>À DURÉE DÉTERMINÉE</h4>
            </div>

            <div class="col-md-12">
                <h5><b style="text-decoration: underline black;">Entre les sousignés :</b></h5>
                <p>La société {{ $contrat[0]->denomination }} au Capital Social de {{ $contrat[0]->capitalSocial }} GNF
                    immatriculée au RCCM sous le numéro {{ $contrat[0]->rccm }}, ayant son siège social sis à
                    {{ $contrat[0]->adresseEntreprise }}, représentée par son dirigent légal, ci-après désignée
                    <b>‘’Employeur’’</b></p>
                <p style="text-align: right;"><b>D'une part</b></p>
                <p style="text-align: left;"><b>Et</b></p>
                <p>{{ $contrat[0]->prefix }} {{ $contrat[0]->prenomEtNom }}, citoyen de nationalité
                    {{ $contrat[0]->nationalite }} né le {{ date('d-m-Y', strtotime($contrat[0]->dateNaissance)) }} à
                    {{ $contrat[0]->lieuNaissance }}, ayant élu domicile aux fins des présentes au siège social de
                    l’Employeur, titulaire d’un {{ $contrat[0]->naturePiece }} N°{{ $contrat[0]->numPiece }} valable
                    jusqu’au {{ date('d-m-Y', strtotime($contrat[0]->dateExPiece)) }} ci-après « <b>Employé</b> » ;</p>
                <p>Lequel déclare être libre de tout engagement autre que celui prévu dans le présent contrat ;</p>
                <p style="text-align: right;"><b> D’autre part </b></p>
                <p>L’Employeur et l’Employé, étant désignés collectivement les « Parties » et individuellement la «
                    Partie » ;</p>
                <h4 style="text-decoration: underline black;text-align:center;margin-top:50px">Il EST CONVENU ET ARRÊTÉ
                    CE QUI SUIT :</h4>
                <p>Le présent contrat est régi par les dispositions de la loi N°L/2014/072/CNT du 10 janvier 2014
                    portant Code du Travail de la République de Guinée (ci-après, « Code du Travail ») et les textes
                    pris en vue de son application ainsi que le règlement intérieur de la COMPAGNIE.</p>
                <h4>ARTICLE 1 : ENGAGEMENT</h4>
                <p>L’Employé est engagé par l’Employeur à compter du
                    {{ date('d-m-Y', strtotime($contrat[0]->dateEmbauche)) }}, sous réserve (i) qu’il soit déclaré apte
                    à l’issue d’un examen médical organisé par l’Employeur dans les plus brefs délais et compte tenu des
                    contraintes liées à la maladie du coronavirus 2019 (Covid 19) et (ii) qu’il fournisse dans le délai
                    imparti tous les documents demandés en vue de l’embauche.
                    Il reste entendu que l’Employé est tenu de se soumettre à l’examen médical et que toute
                    communication par lui d’un document dont le caractère faux est découvert par l’Employeur après
                    l’embauche, constitue une faute grave au sens du présent contrat et justifie de ce fait une
                    cessation immédiate du lien de travail sans indemnité ni préavis.</p>
                <p>L’Employé déclare être libre de tout engagement, et s’oblige :</p>
                <ul>
                    <li>●&nbsp;&nbsp;À effectuer loyalement en toutes circonstances, les missions qui lui seront
                        confiées par l’Employeur et/ou ses représentants ;</li>
                    <li>●&nbsp;&nbsp;À respecter la discipline et les directives de ses supérieurs hiérarchiques ;</li>
                    <li>●&nbsp;&nbsp;À observer rigoureusement l’ensemble des règles et usages en vigueur au sein de
                        l’entreprise.</li>
                </ul>
                <p>L’Employé consent à ce que l’Employeur utilise, traite ou stocke des données personnelles le
                    concernant, y compris des données sur la santé et la sécurité au travail, pour satisfaire aux
                    exigences légales ainsi que dans le cadre de la conduite des affaires de l’Employeur.</p>
                <p>En outre, l’Employé s’engage expressément à adhérer et respecter le Code de conduite et le Règlement
                    Intérieur mis en place par l’Employeur.</p>
                <p>L’Employé est tenu de connaître l’intégralité de la teneur desdits documents dont une copie de chaque
                    sera tenue à sa disposition par l’Employeur à partir de la date d’embauche.</p>
                <h4>ARTICLE 2 : DUREE DU CONTRAT</h4>
                <p>Le présent Contrat est conclu pour une durée de {{ $contrat[0]->dureeContrat }}, à compter du
                    {{ date('d-m-Y', strtotime($contrat[0]->dateSignatureContrat)) }} et prendra fin le
                    {{ date('d-m-Y', strtotime($contrat[0]->dateFinContrat)) }} </p>
                <h4>ARTICLE 3 : FONCTION ET RESPONSABILITÉS</h4>
                <p>L’Employé est engagé pour occuper le poste de Gérant.</p>
                <p>À ce titre, il effectuera toutes les tâches qui sont rattachées à ce poste de gérant dans le cadre de
                    sa fonction.</p>
                <h4>ARTICLE 4 : LIEU D’EMPLOI - MOBILITÉ</h4>
                <p>L’Employé exercera ses fonctions à Conakry. Toutefois, selon les besoins de la société, il pourrait
                    être affecté en tout autre lieu du territoire de la République de Guinée.</p>
                <p>L’Employé pourra en outre être amené, en cas de nécessité pour la société, à effectuer des
                    déplacements ponctuels à l’étranger ou à l’intérieur du pays ne nécessitant pas le changement de sa
                    résidence habituelle. </p>
                <h4>ARTICLE 5 : DUREE DU TRAVAIL</h4>
                <p>Le présent contrat de travail est soumis au régime de quarante (40) heures de travail par semaine à
                    raison de huit (08) heures de travail par jour.
                    Le Code du travail prévoie la possibilité de réaliser des heures supplémentaires.
                </p>
                <h4>ARTICLE 6 : RÉMUNÉRATION</h4>
                <p>En contrepartie de son activité professionnelle, l’employé percevra un salaire mensuel composé comme
                    suit :</p>
                <ul>
                    <li>- salaire de base : GNF {{ $contrat[0]->salaireBase }}</li>
                    <li>- prime de logement : GNF {{ $contrat[0]->primePanier }}</li>
                    <li>- prime de transport : GNF {{ $contrat[0]->primeTransport }}</li>
                    <li>- salaire brut : GNF {{ $contrat[0]->salaireBrut }}</li>
                </ul>
                <p>pour un salaire net de ...... francs guinéens, versé le dernier jour du mois.</p>
                <h4>ARTICLE 7 : CONGÉS</h4>
                <p>L’employé jouira d’un droit aux congés à raison de 2,5 jours ouvrables par mois de travail effectif.
                </p>
                <p>La période de ce congé sera fixée compte tenu des nécessités du service et devra faire l’objet d’une
                    demande de l’Employé et d’un accord écrit de l’Employeur.</p>
                <h4>ARTICLE 8 : AVANTAGES SOCIAUX</h4>
                <p>L’employé bénéficiera du régime d’assurances sociales prévu par la réglementation en vigueur en
                    République de Guinée (Soins médicaux, accident de travail, maladie professionnelle, prestations
                    familiales, retraite).</p>
                <p>Il sera immatriculé à la Caisse nationale de sécurité sociale (CNSS).</p>
                <h4>ARTICLE 9 : EXÉCUTION DU CONTRAT ET EXCLUSIVITÉ</h4>
                <p>L’employé s’engage à observer toutes les instructions et consignes particulières de travail ayant
                    trait à sa fonction. Il s’engage également à consacrer tout son temps, toute son activité et toutes
                    ses connaissances à l’exercice de ses fonctions et à ne s’occuper exclusivement, pendant la durée du
                    présent contrat, que des activités de l’Employeur, s’interdisant formellement de s’intéresser
                    directement ou indirectement à d’autres affaires, sauf accord exprès et préalable de l’employeur.
                </p>
                <h4>ARTICLE 10 : CLAUSE DE CONFIDENTIALITÉ</h4>
                <p>L’employé s’engage pendant la durée de son contrat de travail, et après sa rupture à ne pas divulguer
                    des informations confidentielles sur la société, qu’elles soient en rapport ou non avec sa fonction.
                    Et ceci par quelque moyen que ce soit : oral, verbal, informatique, écrit… et que ce soit à
                    l’intérieur ou à l’extérieur de l’entreprise.</p>
                <h4>ARTICLE 11 : RUPTURE DU CONTRAT</h4>
                <p>Le présent contrat peut être rompu, dans les conditions prévues par la loi :</p>
                <ul>
                    <li>1. D’un commun accord entre les Parties ;</li>
                    <li>2. En cas de faute grave de l’Employé ou de force majeure. Est considéré comme cas de force
                        majeure, tout événement imprévisible, irrésistible et extérieur à la Partie qui l’invoque et
                        dont la survenance empêche l’exécution totale de ses obligations ; </li>
                    <li>3. En cas de cessation d'activité de l'Employeur.</li>
                </ul>
                <h4>ARTICLE 12 : REGLEMENT DES DIFFERENDS</h4>
                <p>Les Parties s’obligent à rechercher une solution amiable à tout différend résultant de
                    l'interprétation ou de l'exécution du présent contrat de travail, dans un délai de trente (30) jours
                    à compter de la réception par l’une d’entre elles de la demande de règlement amiable adressée par
                    l’autre. </p>
                <p>En cas d’échec du règlement amiable ou à l’expiration du délai susmentionné de trente (30) jours,
                    chacune des Parties pourra, sauf accord contraire, porter le différend devant la juridiction
                    territorialement compétente en matière sociale, conformément aux articles 520.1 et suivants du Code
                    du Travail.</p>
                <p style="text-align: right;">{{ $contrat[0]->lieuSignature }}, le
                    {{ date('d-m-Y', strtotime($contrat[0]->dateSignatureContrat)) }}</p>
                <p style="text-align: right;">Fait en deux (02) exemplaires originaux</p>
                <div class="row col-md-12" style="margin-top: 50px;text-align:center">
                    <div class="col-md-6">
                        <h4>L’EMPLOYEUR</h4>
                        <h5>LA SOCIETE {{ $contrat[0]->denomination }} </h5>
                    </div>
                    <div class="col-md-6">
                        <h4>L’EMPLOYE</h4>
                        <h5>{{ $contrat[0]->prefix }} {{ $contrat[0]->prenomEtNom }}</h5>
                    </div>
                </div>

            </div>

        </div>
        @endif
    </div>
</div>

<script>
document.getElementById('clt').classList.add('active');
</script>

@endsection