<?php

namespace App\Http\Controllers;

use App\Models\clients;
use App\Models\courierLiers;
use Illuminate\Support\Facades\Auth;
use App\Models\CourierDepart;
use App\Models\CourierFiles;
use App\Models\Fichiers;
use App\Models\Personnels;
use DateTime;
use Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\IOFactory;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Illuminate\Support\Facades\Log;

class CourierDepartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getAllCourierDepartForSearch($search)
    {
        // récuperation des tâches dans la base de donnees
        $courierDepart = DB::select("select slug,LOWER(objet) as objet from courier_departs where objet like '%$search%'");

        return response()->json([
            'courierDepart' => $courierDepart,
        ]);


        //return view('taches.showTask', compact('taches'));
    }

    public function downloadWordLT(Request $request)
    {

        $idCourier = $request->input('idCourier');

        $courierModel = DB::select("select * from courier_departs,affaires,personnels,clients where courier_departs.idPersonnel=personnels.idPersonnel and courier_departs.idClient=clients.idClient and courier_departs.idAffaire=affaires.idAffaire and courier_departs.idCourierDep=?", [$idCourier]);

        if (!empty($courierModel)) {
            $signataire = DB::select('select * from users where initial=?', [$courierModel[0]->signataire]);
            $annee = date("Y", strtotime($courierModel[0]->created_at));
        } else {
            $signataire = [];
            $annee = '';
        }


        $logo = DB::select("select logo from cabinets");
        // Contenu de la div que vous souhaitez télécharger


        // Création d'un nouvel objet PHPWord
        $phpWord = new PhpWord();
        $dateCourier = new DateTime($courierModel[0]->dateCourier);
        // Ajouter le contenu de la div au document Word
        $section = $phpWord->addSection();

        $section->addImage('' . $logo[0]->logo . '', ['width' => 70, 'height' => 50]);
        $section->addTextBreak(3);
        $leftText = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_LEFT));
        $leftText->addText('Réf. : ');
        $leftText->addText('N° ' . $courierModel[0]->numCourier . '/' . $courierModel[0]->initialPersonnel . '/' . $courierModel[0]->signataire . '/' . $annee . '', ['bold' => true, 'underline' => 'single']);
        $section->addTextBreak(2);
        $centerTextObjet = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $centerTextObjet->addText('Lettre de transmission', ['bold' => true, 'underline' => 'single', 'size' => 12]);
        $section->addTextBreak(1);
        $section->addText('Madame / Monsieur,');
        $section->addText('J\'ai l\'honneur de vous transmettre par la présente, en vue de la création de la SOCIETE ' . $courierModel[0]->denomination . ', les documents ci-dessous énumérés :');
        $listStyle = ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER];
        $section->addListItem('Deux copies des Statuts', 0, null, $listStyle);
        $section->addListItem('Deux copies du PV de constitution', 0, null, $listStyle);
        $section->addListItem('Une copie de l\'attestation du compte bancaire portant', 0, null, $listStyle);
        $section->addListItem('La décharge de la lettre d\'ouverture de compte', 0, null, $listStyle);
        $section->addListItem('Une copie de la pièce d\'identité du/des gérant(s)', 0, null, $listStyle);
        $section->addListItem('Deux (2) photos d\'identité du/des gérant(s)', 0, null, $listStyle);
        $section->addText('Je reste à votre disposition pour tout complément de dossier à fournir.');
        $section->addText('Dans l’attente, veuillez recevoir, Madame/Monsieur, l\'expression de mes salutations distinguées.');
        $section->addTextBreak(2);
        $rightText = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_RIGHT));
        $rightText->addText('Conakry, le ' . $dateCourier->format('d/m/Y') . '', ['underline' => 'single']);
        $section->addTextBreak(2);
        $centerTextMaitre = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $centerTextMaitre->addText('Maître ' . $signataire[0]->name . '', ['size' => 12, 'bold' => true]);
        $centerTextAvocat = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $centerTextAvocat->addText('Avocat à la Cour');

        // Nom du fichier Word à télécharger
        $nomFichier = 'Lettre_de_transmission.docx';

        // Enregistrement du document Word
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($nomFichier);

        // Téléchargement du fichier
        return response()->download($nomFichier)->deleteFileAfterSend(true);
    }

    public function downloadWordLCP(Request $request)
    {

        $idCourier = $request->input('idCourier');

        $courierModel = DB::select("select * from courier_departs,affaires,personnels,clients where courier_departs.idPersonnel=personnels.idPersonnel and courier_departs.idClient=clients.idClient and courier_departs.idAffaire=affaires.idAffaire and courier_departs.idCourierDep=?", [$idCourier]);

        if (!empty($courierModel)) {
            $signataire = DB::select('select * from users where initial=?', [$courierModel[0]->signataire]);
            $annee = date("Y", strtotime($courierModel[0]->created_at));
        } else {
            $signataire = [];
            $annee = '';
        }


        $logo = DB::select("select logo from cabinets");
        // Contenu de la div que vous souhaitez télécharger


        // Création d'un nouvel objet PHPWord
        $phpWord = new PhpWord();
        $dateCourier = new DateTime($courierModel[0]->dateCourier);
        // Ajouter le contenu de la div au document Word
        $section = $phpWord->addSection();

        $section->addImage('' . $logo[0]->logo . '', ['width' => 70, 'height' => 50]);
        $section->addTextBreak(3);
        $leftText1 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_LEFT));
        $leftText1->addText('Affaire : ');
        $leftText1->addText('' . $courierModel[0]->nomAffaire . '', ['bold' => true, 'underline' => 'single']);
        $section->addTextBreak(1);
        $leftText2 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_LEFT));
        $leftText2->addText('Réf. : ');
        $leftText2->addText('N° ' . $courierModel[0]->numCourier . '/' . $courierModel[0]->initialPersonnel . '/' . $courierModel[0]->signataire . '/' . $annee . '', ['bold' => true, 'underline' => 'single']);
        $section->addTextBreak(2);
        $leftTextObjet = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_LEFT));
        $leftTextObjet->addText('Objet : ', ['bold' => true, 'underline' => 'single']);
        $leftTextObjet->addText('Lettre de constitution');
        $rightTextDestinataire = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $rightTextDestinataire->addText('                                                                                                                                   À');
        $rightTextDestinataire2 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_RIGHT));
        $rightTextDestinataire2->addText('' . $courierModel[0]->destinataire . '');
        $rightTextDestinataire3 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_RIGHT));
        $rightTextDestinataire3->addText('Conakry, le ' . $dateCourier->format('d/m/Y') . '', ['underline' => 'single']);
        $section->addTextBreak(1);
        $section->addText('Madame / Monsieur,');
        $section->addText('Nous avons l’honneur de vous informer de ce que notre cabinet a été constitué pour défendre les intérêts de madame/monsieur ' . $courierModel[0]->prenom . ' ' . $courierModel[0]->nom . ', résident à ' . $courierModel[0]->adresse . ' assignée par ' . $courierModel[0]->partieAdverse . ' par devant votre juridiction pour ' . $courierModel[0]->motif . '');
        $section->addTextBreak(1);
        $section->addText('Pour toutes fins utiles que de droit.');
        $section->addText('Nous vous souhaitons bonne réception de la présente et vous prions de recevoir, Monsieur le président, nos salutations toujours respectueuses.');
        $section->addTextBreak(2);
        $centerTextMaitre = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $centerTextMaitre->addText('Maître ' . $signataire[0]->name . '', ['size' => 12, 'bold' => true]);
        $centerTextAvocat = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $centerTextAvocat->addText('Avocat à la Cour');

        // Nom du fichier Word à télécharger
        $nomFichier = 'Lettre_de_constitution_personne.docx';

        // Enregistrement du document Word
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($nomFichier);

        // Téléchargement du fichier
        return response()->download($nomFichier)->deleteFileAfterSend(true);
    }

    public function downloadWordLCS(Request $request)
    {

        $idCourier = $request->input('idCourier');

        $courierModel = DB::select("select * from courier_departs,affaires,personnels,clients where courier_departs.idPersonnel=personnels.idPersonnel and courier_departs.idClient=clients.idClient and courier_departs.idAffaire=affaires.idAffaire and courier_departs.idCourierDep=?", [$idCourier]);

        if (!empty($courierModel)) {
            $signataire = DB::select('select * from users where initial=?', [$courierModel[0]->signataire]);
            $annee = date("Y", strtotime($courierModel[0]->created_at));
        } else {
            $signataire = [];
            $annee = '';
        }


        $logo = DB::select("select logo from cabinets");
        // Contenu de la div que vous souhaitez télécharger
        

        // Création d'un nouvel objet PHPWord
        $phpWord = new PhpWord();
        $dateCourier = new DateTime($courierModel[0]->dateCourier);
        // Ajouter le contenu de la div au document Word
        $section = $phpWord->addSection();

        $section->addImage('' . $logo[0]->logo . '', ['width' => 70, 'height' => 50]);
        $section->addTextBreak(3);
        $leftText1 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_LEFT));
        $leftText1->addText('Affaire : ');
        $leftText1->addText('' . $courierModel[0]->nomAffaire . '', ['bold' => true, 'underline' => 'single']);
        $section->addTextBreak(1);
        $leftText2 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_LEFT));
        $leftText2->addText('Réf. : ');
        $leftText2->addText('N° ' . $courierModel[0]->numCourier . '/' . $courierModel[0]->initialPersonnel . '/' . $courierModel[0]->signataire . '/' . $annee . '', ['bold' => true, 'underline' => 'single']);
        $section->addTextBreak(2);
        $leftTextObjet = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_LEFT));
        $leftTextObjet->addText('Objet : ', ['bold' => true, 'underline' => 'single']);
        $leftTextObjet->addText('Lettre de constitution');
        $rightTextDestinataire = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $rightTextDestinataire->addText('                                                                                                                                   À');
        $rightTextDestinataire2 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_RIGHT));
        $rightTextDestinataire2->addText('' . $courierModel[0]->destinataire . '');
        $rightTextDestinataire3 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_RIGHT));
        $rightTextDestinataire3->addText('Conakry, le ' . $dateCourier->format('d/m/Y') . '', ['underline' => 'single']);
        $section->addTextBreak(1);
        $section->addText('Madame / Monsieur,');
        $section->addText('Nous avons l’honneur de vous informer de ce que notre cabinet a été constitué pour défendre les intérêts de la SOCIETE ' . $courierModel[0]->denomination . ',  ayant son siège à ' . $courierModel[0]->adresseEntreprise . ' immatriculée au Registre de Commerce et du Crédit Mobilier sous le numéro ' . $courierModel[0]->rccm . ' assignée par ' . $courierModel[0]->partieAdverse . ' par devant votre juridiction pour ' . $courierModel[0]->motif . '');
        $section->addTextBreak(1);
        $section->addText('Pour toutes fins utiles que de droit.');
        $section->addText('Nous vous souhaitons bonne réception de la présente et vous prions de recevoir, Monsieur le président, nos salutations toujours respectueuses.');
        $section->addTextBreak(2);
        $centerTextMaitre = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $centerTextMaitre->addText('Maître ' . $signataire[0]->name . '', ['size' => 12, 'bold' => true]);
        $centerTextAvocat = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $centerTextAvocat->addText('Avocat à la Cour');

        // Nom du fichier Word à télécharger
        $nomFichier = 'Lettre_de_constitution_societe.docx';

        // Enregistrement du document Word
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($nomFichier);

        // Téléchargement du fichier
        return response()->download($nomFichier)->deleteFileAfterSend(true);
    }

    public function downloadWordDAP(Request $request)
    {

        $idCourier = $request->input('idCourier');

        $courierModel = DB::select("select * from courier_departs,affaires,personnels,clients where courier_departs.idPersonnel=personnels.idPersonnel and courier_departs.idClient=clients.idClient and courier_departs.idAffaire=affaires.idAffaire and courier_departs.idCourierDep=?", [$idCourier]);

        if (!empty($courierModel)) {
            $signataire = DB::select('select * from users where initial=?', [$courierModel[0]->signataire]);
            $annee = date("Y", strtotime($courierModel[0]->created_at));
        } else {
            $signataire = [];
            $annee = '';
        }


        $logo = DB::select("select logo from cabinets");
        // Contenu de la div que vous souhaitez télécharger


        // Création d'un nouvel objet PHPWord
        $phpWord = new PhpWord();
        $dateCourier = new DateTime($courierModel[0]->dateCourier);
        // Ajouter le contenu de la div au document Word
        $section = $phpWord->addSection();

        $section->addImage('' . $logo[0]->logo . '', ['width' => 70, 'height' => 50]);
        $section->addTextBreak(3);
        $leftText1 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_LEFT));
        $leftText1->addText('Affaire : ');
        $leftText1->addText('' . $courierModel[0]->nomAffaire . '', ['bold' => true, 'underline' => 'single']);
        $section->addTextBreak(1);
        $leftText2 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_LEFT));
        $leftText2->addText('Réf. : ');
        $leftText2->addText('N° ' . $courierModel[0]->numCourier . '/' . $courierModel[0]->initialPersonnel . '/' . $courierModel[0]->signataire . '/' . $annee . '', ['bold' => true, 'underline' => 'single']);
        $section->addTextBreak(2);
        $leftTextObjet = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_LEFT));
        $leftTextObjet->addText('Objet : ', ['bold' => true, 'underline' => 'single']);
        $leftTextObjet->addText('Déclaration d\'appel');
        $rightTextDestinataire = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $rightTextDestinataire->addText('                                                                                                                                   À');
        $rightTextDestinataire2 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_RIGHT));
        $rightTextDestinataire2->addText('' . $courierModel[0]->destinataire . '');
        $rightTextDestinataire3 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_RIGHT));
        $rightTextDestinataire3->addText('Conakry, le ' . $dateCourier->format('d/m/Y') . '', ['underline' => 'single']);
        $section->addTextBreak(1);
        $section->addText('Madame / Monsieur,');
        $section->addText('Par la présente, monsieur/madame ' . $courierModel[0]->prenom . ' ' . $courierModel[0]->nom . ', résident à ' . $courierModel[0]->adresse . ' ,ayant pour avocat Maître ' . $signataire[0]->name . ', avocat à la Cour, déclare, avoir formellement relevé appel contre le jugement ' . $courierModel[0]->jugement . ', rendu dans l’affaire suscitée.');
        $section->addTextBreak(1);       
        $section->addText('L’appelant(e) entend, en effet, développer les motifs de son appel par devant la Cour d’appel de ' . $courierModel[0]->courAppel . '');
        $section->addTextBreak(1);
        $section->addText('Vous en souhaitant bonne réception, nous vous prions d’agréer, monsieur le chef de greffe, nos salutations distinguées.');
        $section->addTextBreak(2);
        $centerTextAppelant = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $centerTextAppelant->addText('Pour l\'appelante', ['underline' => 'single']);
        $centerTextMaitre = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $centerTextMaitre->addText('Maître ' . $signataire[0]->name . '', ['size' => 12, 'bold' => true]);
        $centerTextAvocat = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $centerTextAvocat->addText('Avocat à la Cour');

        // Nom du fichier Word à télécharger
        $nomFichier = 'Declaration_appel_personne.docx';

        // Enregistrement du document Word
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($nomFichier);

        // Téléchargement du fichier
        return response()->download($nomFichier)->deleteFileAfterSend(true);
    }

    public function downloadWordDAS(Request $request)
    {

        $idCourier = $request->input('idCourier');

        $courierModel = DB::select("select * from courier_departs,affaires,personnels,clients where courier_departs.idPersonnel=personnels.idPersonnel and courier_departs.idClient=clients.idClient and courier_departs.idAffaire=affaires.idAffaire and courier_departs.idCourierDep=?", [$idCourier]);

        if (!empty($courierModel)) {
            $signataire = DB::select('select * from users where initial=?', [$courierModel[0]->signataire]);
            $annee = date("Y", strtotime($courierModel[0]->created_at));
        } else {
            $signataire = [];
            $annee = '';
        }


        $logo = DB::select("select logo from cabinets");
        // Contenu de la div que vous souhaitez télécharger


        // Création d'un nouvel objet PHPWord
        $phpWord = new PhpWord();
        $dateCourier = new DateTime($courierModel[0]->dateCourier);
        // Ajouter le contenu de la div au document Word
        $section = $phpWord->addSection();

        $section->addImage('' . $logo[0]->logo . '', ['width' => 70, 'height' => 50]);
        $section->addTextBreak(3);
        $leftText1 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_LEFT));
        $leftText1->addText('Affaire : ');
        $leftText1->addText('' . $courierModel[0]->nomAffaire . '', ['bold' => true, 'underline' => 'single']);
        $section->addTextBreak(1);
        $leftText2 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_LEFT));
        $leftText2->addText('Réf. : ');
        $leftText2->addText('N° ' . $courierModel[0]->numCourier . '/' . $courierModel[0]->initialPersonnel . '/' . $courierModel[0]->signataire . '/' . $annee . '', ['bold' => true, 'underline' => 'single']);
        $section->addTextBreak(2);
        $leftTextObjet = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_LEFT));
        $leftTextObjet->addText('Objet : ', ['bold' => true, 'underline' => 'single']);
        $leftTextObjet->addText('Déclaration d\'appel');
        $rightTextDestinataire = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $rightTextDestinataire->addText('                                                                                                                                   À');
        $rightTextDestinataire2 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_RIGHT));
        $rightTextDestinataire2->addText('' . $courierModel[0]->destinataire . '');
        $rightTextDestinataire3 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_RIGHT));
        $rightTextDestinataire3->addText('Conakry, le ' . $dateCourier->format('d/m/Y') . '', ['underline' => 'single']);
        $section->addTextBreak(1);
        $section->addText('Madame / Monsieur,');
        $section->addText('Par la présente, la société ' . $courierModel[0]->denomination . ', sise à ' . $courierModel[0]->adresseEntreprise . ' ,ayant pour avocat Maître ' . $signataire[0]->name . ', avocat à la Cour, déclare, avoir formellement relevé appel contre le jugement ' . $courierModel[0]->jugement . ', rendu dans l’affaire suscitée.');
        $section->addTextBreak(1);
        $section->addText('Pour toutes fins utiles que de droit.');
        $section->addText('Nous vous souhaitons bonne réception de la présente et vous prions de recevoir, Monsieur le président, nos salutations toujours respectueuses.');
        $section->addTextBreak(1);
        $section->addText('L’appelant(e) entend, en effet, développer les motifs de son appel par devant la Cour d’appel de ' . $courierModel[0]->courAppel . '');
        $section->addTextBreak(1);
        $section->addText('Vous en souhaitant bonne réception, nous vous prions d’agréer, monsieur le chef de greffe, nos salutations distinguées.');
        $section->addTextBreak(2);
        $centerTextAppelant = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $centerTextAppelant->addText('Pour l\'appelante', ['underline' => 'single']);
        $centerTextMaitre = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $centerTextMaitre->addText('Maître ' . $signataire[0]->name . '', ['size' => 12, 'bold' => true]);
        $centerTextAvocat = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $centerTextAvocat->addText('Avocat à la Cour');

        // Nom du fichier Word à télécharger
        $nomFichier = 'Declaration_appel_societe.docx';

        // Enregistrement du document Word
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($nomFichier);

        // Téléchargement du fichier
        return response()->download($nomFichier)->deleteFileAfterSend(true);
    }

    public function downloadWordLDC(Request $request)
    {

        $idCourier = $request->input('idCourier');

        $courierModel = DB::select("select * from courier_departs,affaires,personnels,clients where courier_departs.idPersonnel=personnels.idPersonnel and courier_departs.idClient=clients.idClient and courier_departs.idAffaire=affaires.idAffaire and courier_departs.idCourierDep=?", [$idCourier]);

        if (!empty($courierModel)) {
            $signataire = DB::select('select * from users where initial=?', [$courierModel[0]->signataire]);
            $annee = date("Y", strtotime($courierModel[0]->created_at));
        } else {
            $signataire = [];
            $annee = '';
        }


        $logo = DB::select("select logo from cabinets");
        // Contenu de la div que vous souhaitez télécharger


        // Création d'un nouvel objet PHPWord
        $phpWord = new PhpWord();
        $dateCourier = new DateTime($courierModel[0]->dateCourier);
        $dateProcesVerbal = new DateTime($courierModel[0]->dateProcesVerbal);
        // Ajouter le contenu de la div au document Word
        $section = $phpWord->addSection();

        $section->addImage('' . $logo[0]->logo . '', ['width' => 70, 'height' => 50]);
        $section->addTextBreak(3);
        $leftText2 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_LEFT));
        $leftText2->addText('Réf. : ');
        $leftText2->addText('N° ' . $courierModel[0]->numCourier . '/' . $courierModel[0]->initialPersonnel . '/' . $courierModel[0]->signataire . '/' . $annee . '', ['bold' => true, 'underline' => 'single']);
        $section->addTextBreak(2);
        $rightTextDestinataire = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $rightTextDestinataire->addText('                                                                                                                                   À');
        $rightTextDestinataire2 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_RIGHT));
        $rightTextDestinataire2->addText('' . $courierModel[0]->destinataire . '');
        $rightTextDestinataire3 = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_RIGHT));
        $rightTextDestinataire3->addText('Conakry, le ' . $dateCourier->format('d/m/Y') . '', ['underline' => 'single']);
        $section->addTextBreak(1);
        $leftTextObjet = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_LEFT));
        $leftTextObjet->addText('Objet : ', ['bold' => true, 'underline' => 'single']);
        $leftTextObjet->addText('Demande d’ouverture d’un compte bancaire au nom de la Société ' . $courierModel[0]->denomination . ' en formation');
        $section->addTextBreak(1);
        $section->addText('Madame / Monsieur,');
        $section->addText('En vertu du procès-verbal de l’assemblée générale constitutive en date du ' . $dateProcesVerbal->format('d/m/Y') . ', et pour nous permettre de procéder à la libération du capital social, nous venons par la présente, solliciter l’ouverture d’un compte bancaire au nom de la société ' . $courierModel[0]->denomination . ' en formation');
        $section->addTextBreak(1);
        $section->addText('Outre la libération du capital social, le compte bancaire dont l’ouverture est sollicitée recevra tous les revenus escomptés par l’entreprise.');
        $section->addTextBreak(1);
        $section->addText('À l’appui de la présente, nous vous communiquons les pièces suivantes :');
        $section->addTextBreak(1);
        $listStyle = ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER];
        $section->addListItem('une copie des Statuts ;', 0, null, $listStyle);
        $section->addListItem('une copie du procès-verbal de constitution ;', 0, null, $listStyle);
        $section->addListItem('une copie des pièces d’identité des associés ;', 0, null, $listStyle);
        $section->addListItem('un certificat de résidence du/des gérant(s) ;', 0, null, $listStyle);
        $section->addListItem('deux photos d’identité du/des gérant(s).', 0, null, $listStyle);
        $section->addTextBreak(1);
        $section->addText('Nous nous tenons à votre disposition pour tout complément de dossier à fournir.');
        $section->addTextBreak(1);
        $section->addText('Dans l’attente d’une suite favorable, nous vous prions de recevoir, monsieur le Directeur général, l’expression de nos salutations distinguées.');
        $section->addTextBreak(2);

        $centerTextMaitre = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $centerTextMaitre->addText('Maître ' . $signataire[0]->name . '', ['size' => 12, 'bold' => true]);
        $centerTextAvocat = $section->addTextRun(array('alignment' => Alignment::HORIZONTAL_CENTER));
        $centerTextAvocat->addText('Avocat à la Cour');

        // Nom du fichier Word à télécharger
        $nomFichier = 'Ouverture_compte_bancaire.docx';

        // Enregistrement du document Word
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($nomFichier);

        // Téléchargement du fichier
        return response()->download($nomFichier)->deleteFileAfterSend(true);
    }


    public function index()
    {
        $couriers = DB::select("select * from courier_departs");
        return view('couriers.depart.allCourierDepart', compact('couriers'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allCourierSent()
    {
        $couriers = CourierDepart::all();
        return view('couriers.depart.allCourierDepart', compact('couriers'));
    }

    /**
     * Afficher the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $slugSuivit = request()->route('slug');
       
        if ($slugSuivit) {
            $suiviAudiences = DB::select("select * from suivit_audiences where slug=?",[$slugSuivit]);
        } else {
            $suiviAudiences = DB::select("select * from suivit_audiences where typeDecision='viderDeliberer' ");

        }
        
        // Recuperation des donnees des Personnels
        $personnels = Personnels::all();

        $admins = DB::select("select * from users where role='Administrateur'");

        // Recuperation des données des clients dans la base données
      // Récuperation de l'ensemble des clients dans la base de donnees'
      if (Auth::user()->role=='Collaborateur') {
            $clients = DB::table('clients')
            ->join('affectation_personnels', 'clients.idClient', '=', 'affectation_personnels.idClient')
            ->join('personnels', 'affectation_personnels.idPersonnel', '=', 'personnels.idPersonnel')
            ->where('personnels.email', Auth::user()->email)
            ->select('clients.*')
            ->get();        
        }else {
            $clients = DB::select('select * from clients');
        }

        // Comptage des nombres de courier depart
        $idCourier = CourierDepart::all()->count() == 0 ? 1 : CourierDepart::all()->count() + 1;

        

        $juriductions = DB::select("select * from juriductions");

        $verif = DB::select('select * from courier_departs order by numCourier Desc limit 1 ');
        if (empty($verif)) {
            $idCourier = 1;
        } else {
            $idCourier =  $verif[0]->numCourier + 1;
        }

        $courierArrivers = DB::select("select * from courier_arrivers where statut !='Annulé' ");
        $courierDeparts = DB::select("select * from courier_departs where statut !='Annulé' ");

        //$idCourier = 'N°'.$id.'/AD/ASK/'.date('Y');
        return view('couriers.depart.courierSentForm', compact('personnels', 'clients', 'idCourier', 'admins', 'juriductions','courierArrivers','courierDeparts','suiviAudiences'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // l'instanciation du model courier depart
        $courierSent = new CourierDepart();

        // linstanciation du model courierFile
        $courierFile = new Fichiers();


        //personnel connecter
        if (Session::has('idPersonnel')) {
            foreach (Session::get('idPersonnel') as $Personnel) {
                $idPersonConnected = $Personnel->idPersonnel;
            }
        } else {
            $idPersonConnected = 'admin';
        }

        $cabinet = DB::select("select * from cabinets");

        if ($request != null) {

            $courierSent->destinataire = $request->destinataire;
            $courierSent->numCourier = $request->idCourier;
            $courierSent->objet = $request->objet;
            $courierSent->dateCourier = $request->dateCourier;
            $courierSent->idPersonnel = $request->idPersonnel;
            $courierSent->expediteur = $cabinet[0]->nomCabinet;
            $courierSent->idClient = $request->idClient;
            $courierSent->idAffaire = $request->idAffaire;
            $courierSent->partieAdverse = $request->partieAdverse;
            $courierSent->motif = $request->motif;
            $courierSent->jugement = $request->jugement;
            $courierSent->courAppel = $request->courAppel;
            $courierSent->dateProcesVerbal = $request->dateProcesVerbal;
            $courierSent->typeModel = $request->typeModel;
            $courierSent->signataire = $request->signataire;
            $courierSent->dateEnvoi = '';
            $courierSent->dateReception = '';
            $courierSent->numeroRecu = '';
            $courierSent->niveau = 'Approbation';
            $courierSent->statut = 'Transmis';
            $courierSent->confidentialite = $request->confidentialite;
            $courierSent->slug = $request->_token . rand(5665, 12873);

    

            // Creation des fichiers
            // dossiers : affaires,taches,audiences,courier-departs,courier-arrivers
            if ($request->file('fichiers') != null) {

                $fichiers = request()->file('fichiers');


                foreach ($fichiers as $fichier) {

                    $courierFile = new Fichiers();

                    $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                    $courierFile->nomOriginal = $fichier->getClientOriginalName();
                    $courierFile->slugSource = $courierSent->slug;
                    $courierFile->filename = $filename;
                    $courierFile->slug = $request->_token . "" . rand(1234, 3458);
                    $courierFile->path = 'assets/upload/fichiers/courier-departs/' . $filename;
                    $fichier->move(public_path('assets/upload/fichiers/courier-departs'), $filename);
                    $courierFile->save();
                }
            }
            /*

            //personnel connecter
            if (Session::has('idPersonnel')) {
                foreach (Session::get('idPersonnel') as $Personnel) {
                    $idPersonConnected = $Personnel->idPersonnel;
                }
                $admins = DB::select("select * from users where role='Administrateur'");

                    foreach ($admins as $a) {
                        DB::select(
                            'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                            [
                                'Courriers - Départ',
                                "Un courrier départ a été enregistré.",
                                'masquer',
                                'admin',
                                $request->_token . "" . rand(1234, 3458),
                                'non',
                                "infoCourierDepart",
                                $courierSent->slug,
                                $a->id
                            ]
                        );
                    }
            } else {
                $assistantSelect = DB::select("select personnels.idPersonnel as idPersonnel,personnels.email,users.email from personnels,users where personnels.email = users.email and users.role='Assistant'");
                if (empty($assistantSelect)) {
                    $assistant = 'Assistant';
                } else {
                    $assistant = $assistantSelect[0]->idPersonnel;
                }

                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                    [
                        'Courriers - Départ',
                        "Un courrier départ a été enregistré.",
                        'masquer',
                        $assistant,
                        $request->_token . "" . rand(1234, 3458),
                        'non',
                        "infoCourierDepart",
                        $courierSent->slug
                    ]
                );
            }

            */
            $admins = DB::select("select * from users where role='Administrateur'");

            foreach ($admins as $a) {
                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                    [
                        'Courriers - Départ',
                        "Un courrier arrivé a été enregistré.",
                        'masquer',
                        'admin',
                        'non',
                        $request->_token . "" . rand(1234, 3458),
                        "infoCourierDepart",
                        $courierSent->slug,
                        $a->id
                    ]
                );
            }

            $assistantSelect = DB::select("select personnels.idPersonnel as idPersonnel,personnels.email,users.email from personnels,users where personnels.email = users.email and users.role='Assistant'");
           
            foreach($assistantSelect as $assistant){
                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                    [
                        'Courriers - Départ',
                        "Un courrier arrivé a été enregistré.",
                        'masquer',
                        $assistant->idPersonnel,
                        'non',
                        $request->_token . "" . rand(1234, 3458),
                        "infoCourierDepart",
                        $courierSent->slug
                    ]
                );
            }

            $slug = $courierSent->slug;

        
            // Enregistrement du courrier
            $courierSent->save();

            $cleCommune = $request->_token . "" . rand(1234, 3458);

            courierLiers::create([
                'slugCourierLier' => $slug,
                'cleCommune' => $cleCommune,
                'slug' => $request->_token . "" . rand(1234, 3458),
            ]);

            foreach ($request->idCourierLier as $key => $value) {
                if ($value==0) {
                 # ne rien faire
                } else {
                 courierLiers::create([
                     'slugCourierLier' => $value,
                     'cleCommune' => $cleCommune,
                     'slug' => $request->_token . "" . rand(1234, 3458),
                 ]);
                }
                
             }

             if ($request->slugSuivitAudience!='') {
                DB::update("update suivit_audiences set rappelLettre='ne_pas_rappeler' where slug=?",[$request->slugSuivitAudience]);
             }

            return redirect()->route('infoCourierDepart',  [$slug])->with('success', 'Enregistrement effectué avec succès !');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //Update de notification
        $email = Auth::user()->email;
        $personnel = DB::select('select * from personnels where email=? ', [$email]);
        $paramCabinet = DB::select("select * from cabinets");
        $annuaires = DB::select('select * from annuaires');


        if (empty($personnel)) {
            
            DB::update("update notifications set etat='vue' where idRecepteur='admin' and idAdmin=? and urlParam=?", [Auth::user()->id,$slug]);
        } else {
            $idPersonnel = $personnel[0]->idPersonnel;
            $etat = 'vue';
            $idPerso = strval($idPersonnel);
            DB::select(
                'UPDATE notifications SET etat=? where idRecepteur=? AND urlParam=?',
                [$etat, $idPerso, $slug]
            );
        }

        $courierSent = DB::select("select * from courier_departs where slug=?", [$slug]);
        
        $courierFile = DB::select("select * from fichiers where slugSource=?", [$slug]);

        $courierModel = DB::select("select * from courier_departs,affaires,personnels,clients where courier_departs.idPersonnel=personnels.idPersonnel and courier_departs.idClient=clients.idClient and courier_departs.idAffaire=affaires.idAffaire and courier_departs.slug=?", [$slug]);
        if (!empty($courierModel)) {
           
            $signataire = DB::select('select * from users where initial=?', [$courierModel[0]->signataire]);
            $annee = date("Y", strtotime($courierModel[0]->created_at));
        } else {
            $signataire = [];
            $annee = '';
        }

        $clientAffaire = DB::select("select clients.idClient, affaires.idAffaire, prenom, nom, denomination,nomAffaire, clients.slug as slugClient, affaires.slug as slugAffaire from courier_departs,clients,affaires where courier_departs.idClient=clients.idClient and courier_departs.idAffaire=affaires.idAffaire and courier_departs.slug=?",[$slug]);


        if (empty($courierSent)) {
           
          return redirect()->back()->with('error', 'Courrier introuvable !');

        }else {
            
            
            if ($courierSent[0]->niveau == "Terminé") {

                return redirect()->route('detailCourierDepart', [$courierSent[0]->slug]);
    
            } else {
                //dd($slug, $courierFile, $courierSent, $courierSent, $courierModel, $signataire, $annee, $clientAffaire, $courierArrivers);
                return view('couriers.depart.courierSentViewForm', compact('slug', 'courierFile', 'courierSent', 'courierModel', 'signataire', 'annee','clientAffaire','paramCabinet','annuaires'));
            }
        }

       

       
    }

    /**
     * Afficher the form for editing the specified resource.
     *
     * @param  \App\Models\CourierDepart  $courierDepart
     * @return \Illuminate\Http\Response
     */
    public function reprendreCourier(Request $request, $slug)
    {



        // $idCourier = DB::select('select id from courier_departs where slug=?', [$slug]);
        // $file = DB::select('select nomFiles from courier_files where idCourier=?', [$idCourier[0]->id]);

        // if (empty($file)) {
        //     # code...
        // } else {
        //     unlink(public_path('assets/upload/files/' . $file[0]->nomFiles));
        //     DB::delete("delete from courier_departs where slug=?", [$slug]);
        //     DB::delete("delete from courier_files where idCourier=?", [$idCourier[0]->id]);
        //     return redirect()->route('createCourierDepart');
        // }

        //personnel connecter
        if (Session::has('idPersonnel')) {
            foreach (Session::get('idPersonnel') as $Personnel) {
                $idPersonConnected = $Personnel->idPersonnel;
            }
                    $admins = DB::select("select * from users where role='Administrateur'");

                    foreach ($admins as $a) {
                        DB::select(
                            'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                            [
                            'Courriers - Départ',
                            "Un courrier départ a été repris, par consequant il est annulé",
                            'masquer',
                            'admin',
                            'non',
                            $request->_token . "" . rand(1234, 3458),
                            "infoCourierDepart",
                            $slug,
                            $a->id
                            ]
                        );
                    }
        } else {
            $assistant = DB::select("select personnels.idPersonnel as idPersonnel,personnels.email,users.email from personnels,users where personnels.email = users.email and users.role='Assistant'");

            DB::select(
                'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                [
                    'Courriers - Départ',
                    "Un courrier départ a été repris.",
                    'masquer',
                    $assistant[0]->idPersonnel,
                    'non',
                    $request->_token . "" . rand(1234, 3458),
                    "infoCourierDepart",
                    $slug
                ]
            );
        }


        DB::update("update courier_departs set statut='Annulé' where slug=?", [$slug]);
        return redirect()->route('createCourierDepart')->with('success', 'Courrier annulé avec succès !');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function completCourier(Request $request)
    {
        $slug  = $request->courierSlug;
        $courierDepart = CourierDepart::where('slug', $slug);
        $courierDepart->update(
            [
                'dateEnvoi' => $request->dateEnvoi,
                'nomPersonne' => $request->nomPersonne,
                'telephonePersonne' => $request->telephonePersonne,
                'niveau' => 'Accusé réception',
                'statut' => 'Envoyé'
            ]
        );

        $admins = DB::select("select * from users where role='Administrateur'");

        foreach ($admins as $a) {
            DB::select(
                'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                [
                    'Courriers - Départ',
                    "Un courrier arrivé a été enregistré.",
                    'masquer',
                    'admin',
                    'non',
                    $request->_token . "" . rand(1234, 3458),
                    "infoCourierDepart",
                    $slug ,
                    $a->id
                ]
            );
        }

        $assistantSelect = DB::select("select personnels.idPersonnel as idPersonnel,personnels.email,users.email from personnels,users where personnels.email = users.email and users.role='Assistant'");
       
        foreach($assistantSelect as $assistant){
            DB::select(
                'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                [
                    'Courriers - Départ',
                    "Un courrier arrivé a été enregistré.",
                    'masquer',
                    $assistant->idPersonnel,
                    'non',
                    $request->_token . "" . rand(1234, 3458),
                    "infoCourierDepart",
                    $slug ,
                ]
            );
        }



        // $courierSent = DB::select('select * from courier_departs where slug = ?', array($slug));

        // $courierFile =  DB::select('select * from courier_files where idCourier = ?', array($courierSent[0]->id));

        // return view('couriers.depart.courierAccuserForm', compact('courierFile', 'courierSent'));

        return redirect()->route('infoCourierDepart', $slug)->with('success', 'Le courier a été envoyé avec succès !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accuserCourier(Request $request)
    {
        $slugCourier  = $request->slugCourier;
        $slugAccuser  = $request->_token . "" . rand(1234, 3458);
        // Creation des fichiers
        // dossiers : affaires,taches,audiences,courier-departs,courier-arrivers
        if ($request->file('fichiers') != null) {

            $fichiers = request()->file('fichiers');


            foreach ($fichiers as $fichier) {

                $accuserFile = new Fichiers();

                $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                $accuserFile->nomOriginal = $fichier->getClientOriginalName();
                $accuserFile->slugSource = $slugAccuser;
                $accuserFile->filename = $filename;
                $accuserFile->slug =  $slugAccuser;
                $accuserFile->path = 'assets/upload/fichiers/courier-departs/' . $filename;
                $fichier->move(public_path('assets/upload/fichiers/courier-departs'), $filename);
                $accuserFile->save();
            }
        }


        $courierDepart = CourierDepart::where('slug', $slugCourier);
        $courierDepart->update(
            [
                'dateReception' => $request->dateReception,
                'numeroRecu' => $request->numeroRecu,
                'accuse_reception' => $slugAccuser,
                'niveau' => 'Terminé',
                'statut' => 'Terminé',
            ]
        );
        return redirect()->route('listCourierDepart')->with('success', 'La procedure du courrier est terminée avec succès !');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accuser(Request $request)
    {
        $slug  = $request->slug;


        $courierSent = DB::select('select * from courier_departs where slug = ?', array($slug));


        $courierFile = DB::select("select * from courier_files where idCourier=? and typeCourier='Courier Depart'", array($courierSent[0]->id));

        return view('couriers.depart.courierAccuserForm', compact('courierFile', 'courierSent'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function informationDuty($slug)
    {

    
        $courierSent = DB::select('select * from courier_departs where slug = ?', [$slug]);

        $cleCommune = DB::select('select * from courier_liers where slugCourierLier=?',[$slug]);

        $courierDepartLiers = [];
        $courierArriverLiers = [];

        if (!empty($cleCommune)) {

            foreach ($cleCommune as $key => $value) {

                $courierDepartLiersItem = DB::select("SELECT courier_departs.slug as slugDepart,numCourier, courier_departs.idCourierDep, courier_liers.slugCourierLier, courier_liers.slug as slugTCourierLier, cleCommune, objet
                FROM courier_departs, courier_liers 
                WHERE courier_departs.slug = courier_liers.slugCourierLier AND courier_liers.cleCommune = :cle1",['cle1' => $value->cleCommune]);

                $courierArriverLiersItem = DB::select("SELECT courier_arrivers.slug as slugArriver,numero, courier_liers.slugCourierLier, courier_liers.slug as slugTCourierLier, cleCommune, courier_arrivers.idCourierArr, objet
                FROM courier_arrivers, courier_liers 
                WHERE courier_arrivers.slug = courier_liers.slugCourierLier AND courier_liers.cleCommune = :cle2",['cle2' => $value->cleCommune]);

                $courierDepartLiers = array_merge($courierDepartLiers, $courierDepartLiersItem);
                $courierArriverLiers = array_merge($courierArriverLiers, $courierArriverLiersItem);
                
            }
         
        }
       
        $accuser = DB::select('select fichiers.slug from courier_departs,fichiers where courier_departs.accuse_reception=fichiers.slugSource and courier_departs.slug = ?', [$slug]);

        $courierFile =  DB::select("select * from fichiers where slugSource = ? ", [$slug]);

        $clientAffaire = DB::select("select clients.idClient, affaires.idAffaire, prenom, nom, denomination,nomAffaire, clients.slug as slugClient, affaires.slug as slugAffaire from courier_departs,clients,affaires where courier_departs.idClient=clients.idClient and courier_departs.idAffaire=affaires.idAffaire and courier_departs.slug=?",[$slug]);

        //$courierArrivers = DB::select("select * from courier_arrivers where statut !='Annulé' ");
       // $courierDeparts = DB::select("select * from courier_departs where statut !='Annulé' ");

       $courierArrivers = DB::select("select * from courier_arrivers where  statut !='Annulé' ");
       $courierDeparts = DB::select("select * from courier_departs where  statut !='Annulé' ");
      // dd($courierArrivers,$courierDeparts);
      $client = DB::select("select * from clients");

      $courriersArriverCabinet = DB::select("SELECT * FROM courier_arrivers WHERE statut != 'Annulé' AND idAffaire is null  AND (? IS NULL OR courier_arrivers.slug != ?) ",[$slug,$slug] );
    
      $courriersDepartCabinet = DB::select("SELECT * FROM courier_departs WHERE  statut != 'Annulé' AND idAffaire is null AND (? IS NULL OR courier_departs.slug != ?) ",[$slug,$slug]);

        $suggeCourierDepart = DB::select("
        SELECT ca.*, cd.slug as slugDepart, c.*, a.*
        FROM courier_arrivers ca
        INNER JOIN clients c ON ca.idClient = c.idClient
        INNER JOIN courier_departs cd ON cd.idClient = c.idClient
        INNER JOIN affaires a ON ca.idAffaire = a.idAffaire
        WHERE ca.statut != 'Annulé'
        AND cd.slug = ?
    ", [$slug]);

        $infoCourierArrivers = DB::SELECT(" SELECT * FROM courier_arrivers,clients,affaires ,courier_liers where clients.idClient = courier_arrivers.idClient and affaires.idAffaire = courier_arrivers.idAffaire and courier_liers.slugCourierLier = courier_arrivers.slug");
       
        
       // dd( $infoCourier);
    
        
       $infoCourierDepart = DB::SELECT(" SELECT * FROM courier_departs,clients,affaires ,courier_liers where clients.idClient = courier_departs.idClient and affaires.idAffaire = courier_departs.idAffaire and courier_liers.slugCourierLier = courier_departs.slug");
        
        
        //dd($infoCourierDepart);

        return view('couriers.depart.infoCourierDepart', compact('courierFile', 'courierSent','accuser','clientAffaire','courierDepartLiers','courierArriverLiers','courierArrivers','courierDeparts','client','courriersArriverCabinet','courriersDepartCabinet','suggeCourierDepart','infoCourierDepart'));
    }

    public function envoiCourier(Request $request)
    {

        if ($request) {

            $consigne = $request->consignes;
            $slug = $request->slug;

            DB::update("update courier_departs set statut='Approuvé',niveau='Procedure envoi', consignes=? where slug=? ", [$consigne, $slug]);
            //personnel connecter
            if (Session::has('idPersonnel')) {
                foreach (Session::get('idPersonnel') as $Personnel) {
                    $idPersonConnected = $Personnel->idPersonnel;
                }
                 $admins = DB::select("select * from users where role='Administrateur'");

                    foreach ($admins as $a) {
                        DB::select(
                            'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                            [
                                'Courriers - Départ',
                                "Un courrier départ a été aprouver.",
                                'masquer',
                                'admin',
                                'non',
                                $request->_token . "" . rand(1234, 3458),
                                "infoCourierDepart",
                                $slug,
                                $a->id
                            ]
                        );
                    }
            } else {
                $assistant = DB::select("select personnels.idPersonnel as idPersonnel,personnels.email,users.email from personnels,users where personnels.email = users.email and users.role='Assistant'");

                foreach($assistant as $a ){
                    DB::select(
                        'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                        [
                            'Courriers - Départ',
                            "Un courrier départ a été aprouver.",
                            'masquer',
                            $a->idPersonnel,
                            'non',
                            $request->_token . "" . rand(1234, 3458),
                            "infoCourierDepart",
                            $slug
                        ]
                    );
                }
               
            }
            return redirect()->route('infoCourierDepart', $slug)->with('success', 'Le courrier a été approuvé avec succès !');
        }



        // //$courierSent = CourierDepart::where('slug', $courierSlug);

        // $courierSent = DB::select('select * from courier_departs where slug = ?', [$courierSlug]);

        // $courierFile =  DB::select('select * from courier_files where idCourier = ?', array($courierSent[0]->id));


        // return view('couriers.depart.courierSent', compact('courierSlug', 'courierSent', 'courierFile'));
    }

    public function desapprouveCourier(Request $request)
    {
        if ($request) {



            $consigne = $request->consignes;
            $slug = $request->slug;

            //personnel connecter
            if (Session::has('idPersonnel')) {
                foreach (Session::get('idPersonnel') as $Personnel) {
                    $idPersonConnected = $Personnel->idPersonnel;
                }
                $admins = DB::select("select * from users where role='Administrateur'");

                    foreach ($admins as $a) {
                        DB::select(
                            'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                            [
                            'Courriers - Départ',
                            "Un courrier départ a été desaprouver.",
                            'masquer',
                            'admin',
                            'non',
                            $request->_token . "" . rand(1234, 3458),
                            "infoCourierDepart",
                            $slug,
                            $a->id
                            ]
                        );
                    }
            } else {
               // $assistant = DB::select("select personnels.idPersonnel as idPersonnel,personnels.email,users.email from personnels,users where personnels.email = users.email and users.role='Assistant'");
                $assistant = DB::select("select personnels.idPersonnel as idPersonnel,personnels.email,users.email from personnels,users where personnels.email = users.email and users.role='Assistant'");

                foreach( $assistant as $a){
                    DB::select(
                        'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                        [
                            'Courriers - Départ',
                            "Un courrier départ a été desaprouver.",
                            'masquer',
                            $a->idPersonnel,
                            'non',
                            $request->_token . "" . rand(1234, 3458),
                            "infoCourierDepart",
                            $slug
                        ]
                    );
                }

               

                
            }
            $updateStatut = DB::update("update courier_departs set statut='Désapprouvé',niveau='Approbation',consignes=? where slug=? ", [$consigne, $slug]);
            return redirect()->route('infoCourierDepart', $slug)->with('success', 'Le courier a été desaprouver ');
        }
        // return view('couriers.depart.courierSent', compact('courierSlug', 'courierSent', 'courierFile'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourierDepart  $courierDepart
     * @return \Illuminate\Http\Response
     */
    public function deleteCourierDepart(Request $request)
    {
        $slug = $request->slug;

        // $fichier = DB::select("select * from fichiers where slugSource=?", [$slug]);
        // // Suppression des fichiers lié au suivi
        // if (!empty($fichier)) {
        //     foreach ($fichier as $key => $value) {

        //         if (file_exists($value->path)) {
        //             unlink(public_path($value->path));
        //         } else {
                   
        //         }
        //     }
        //     DB::delete("delete from fichiers where slugSource=? ", [$slug]);
        // } else {
        // }

        // DB::delete("delete from courier_departs where slug=?", [$slug]);
        DB::select("update courier_departs set statut='Annulé' where slug=?",[$slug]);
        return back()->with('success', 'Courrier annulé avec succès');
    }

    public function offConfDepart($slug)
    {
        DB::update("update courier_departs set confidentialite='off' where slug=?",[$slug]);
        return back()->with('success', 'Confidentialité désactiver avec succès');
    }

    public function onConfDepart($slug)
    {
        DB::update("update courier_departs set confidentialite='on' where slug=?",[$slug]);
        return back()->with('success', 'Confidentialité activer avec succès');
    }

    public function sendCourrierMail(Request $request)
    {
        $cabinet = DB::select("select * from cabinets"); 
        $serveurEmail = DB::select("select * from serveur_mails");
       
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = $serveurEmail[0]->host;           //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = $cabinet[0]->emailContact;   //  sender username
            $mail->Password = $cabinet[0]->cleContact;       // sender password
            $mail->SMTPSecure = $serveurEmail[0]->smtpSecure;                  // encryption - ssl/tls
            $mail->Port = $serveurEmail[0]->smtpPort;                        // port - 587/465
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->setFrom($cabinet[0]->emailContact, $cabinet[0]->nomCabinet);
            $mail->addAddress($request->input('email'));
            // dd($request->input('email'));
            if (!empty($request->input('emails'))) {
                for ($i = 0; $i < count($_POST['emails']); $i++) {
                    $mail->addCC($_POST['emails'][$i]);
                }
            }
          


            if ($_FILES['attachment']['tmp_name'][0] != "") {
                for ($i = 0; $i < count($_FILES['attachment']['tmp_name']); $i++) {
                    $mail->addAttachment($_FILES['attachment']['tmp_name'][$i], $_FILES['attachment']['name'][$i]);
                }
            }



            $mail->isHTML(true);                // Set email content format to HTML
            $mail->Subject = $request->objet;
            $mail->CharSet = "UTF-8";
            $mail->Encoding = 'base64';
            $mail->Body = $body = "
           
                <div class='container'>
                    
                     $request->body <br/><br/><br/>
                    ".$cabinet[0]->signature."
        
                </div>
          
            ";

            // $mail->AltBody = plain text version of email body;

            if (!$mail->send()) {
                return back()->with("error", "Message non envoyé ! Réessayez à nouveau.")->withErrors($mail->ErrorInfo);
                
            } else {
                $enCharge = Auth::user()->name;
                $today = date('Y-m-d H:i:s'); // date du jour
                $slugCourier  = $request->slugCourier;
                $slugAccuser  = $request->_token . "" . rand(1234, 3458);
                $courierDepart = CourierDepart::where('slug', $slugCourier);
                $courierDepart->update(
                    [
                        'dateReception' => $today,
                        'dateEnvoi' => $today,
                        'numeroRecu' => 'N/A',
                        'nomPersonne' => $enCharge,
                        'accuse_reception' => $slugAccuser,
                        'niveau' => 'Terminé',
                        'statut' => 'Terminé',
                    ]
                );

                $admins = DB::select("select * from users where role='Administrateur'");

                foreach ($admins as $a) {
                    DB::select(
                        'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                        [
                            'Courriers - Départ',
                            "ce courrier a été envoyé par mail.",
                            'masquer',
                            'admin',
                            'non',
                            $request->_token . "" . rand(1234, 3458),
                            "infoCourierDepart",
                            $slugCourier,
                            $a->id
                        ]
                    );
                }
    
                $assistantSelect = DB::select("select personnels.idPersonnel as idPersonnel,personnels.email,users.email from personnels,users where personnels.email = users.email and users.role='Assistant'");
               
                foreach($assistantSelect as $assistant){
                    DB::select(
                        'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                        [
                            'Courriers - Départ',
                            "ce courrier a été envoyé par mail.",
                            'masquer',
                            $assistant->idPersonnel,
                            'non',
                            $request->_token . "" . rand(1234, 3458),
                            "infoCourierDepart",
                            $slugAccuser
                        ]
                    );
                }
                

                return back()->with("success", "Email envoyé avec succès...");
            }

           

        } catch (Exception $e) {
           

            return back()->with('error', 'Erreur d\'envoie de mail. Veuillez vous assurer que vous êtes connecté à internet et que les emails sont bien configurés dans les paramètres avancés.');
        }
    }

    public function soumetre(Request $request)
    {
        $slug = $request->input('slugCourier');
    
        // Récupération du courrier + client + affaire
        $courierClient = DB::table('courier_departs')
            ->join('clients', 'courier_departs.idClient', '=', 'clients.idClient')
            ->join('affaires', 'courier_departs.idAffaire', '=', 'affaires.idAffaire')
            ->select(
                'courier_departs.objet as objetCourier',
                'courier_departs.idClient',
                'courier_departs.idAffaire',
                'clients.email as emailClient',
                'clients.prenom as clientPrenom',
                'clients.nom as nomClient'
            )
            ->where('courier_departs.slug', $slug)
            ->first();
    
        // Récupération des fichiers liés par slugSource = $slug
        $courierFiles = DB::select("SELECT * FROM fichiers WHERE slugSource = ?", [$slug]);
        
    
        // Configuration cabinet et serveur mail
        $cabinet = DB::table('cabinets')->first();
        $serveurEmail = DB::table('serveur_mails')->first();
    
        if (!$cabinet || !$serveurEmail) {
            return back()->with('error', "Configuration du cabinet ou du serveur mail manquante.");
        }
    
        // Données client
        $email  = $courierClient->emailClient;
        $objet  = $courierClient->objetCourier;
        $prenom = $courierClient->clientPrenom;
        $nom    = $courierClient->nomClient;
    
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host       = $serveurEmail->host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $cabinet->emailFinance;
            $mail->Password   = $cabinet->cleFinance;
            $mail->SMTPSecure = $serveurEmail->smtpSecure;
            $mail->Port       = $serveurEmail->smtpPort;
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
            ];
    
            $mail->setFrom($cabinet->emailFinance, $cabinet->nomCabinet);
            $mail->addAddress($email, "$prenom $nom");
            $mail->addAddress($cabinet->emailContact);
    
            // Attacher les fichiers (physiquement) : on utilise le chemin public
            $inlineImagesHtml = ''; // si on veut afficher les images inline
            foreach ($courierFiles as $index => $file) {
                // $file->path est par ex. "assets/upload/fichiers/courier-departs/xxx.png"
                $fullPath = public_path($file->path);
                $filename = $file->filename ?? basename($file->path);
    
                if (file_exists($fullPath)) {
                    // Joindre comme pièce jointe
                    $mail->addAttachment($fullPath, $filename);
    
                    // Si c'est une image, intégrer inline aussi (optionnel)
                    $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                        // cid unique par fichier
                        $cid = "img{$index}";
                        $mail->addEmbeddedImage($fullPath, $cid, $filename);
                        $inlineImagesHtml .= "<p>Prévisualisation :<br><img src=\"cid:$cid\" style=\"max-width:300px; height:auto;\" /></p>";
                    }
                } else {
                    \Log::warning("Fichier introuvable pour attachement : $fullPath");
                }
            }
    
            // Corps du mail
            $body = "
                <div class='container'>
                    <p>Madame / Monsieur <strong>$prenom $nom</strong>,</p>
                    <p>Nous vous informons que le courrier intitulé « <strong>$objet</strong> » a été envoyé avec les documents ci-joints.</p>
                    $inlineImagesHtml
                    <p>Vous pouvez télécharger les pièces jointes directement depuis cet email.</p>
                    <p>Cordialement,<br>{$cabinet->nomCabinet}<br>{$cabinet->signature}</p>
                </div>
            ";
    
            $mail->isHTML(true);
            $mail->Subject = "Notification d'envoi de courrier : $objet";
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->Body = $body;
            $mail->AltBody = "Bonjour $prenom $nom,\n\nNous vous informons que le courrier intitulé \"$objet\" a été envoyé avec ses documents joints.\n\nCordialement,\n{$cabinet->nomCabinet}";
    
            if (!$mail->send()) {
                \Log::error("Erreur envoi mail : " . $mail->ErrorInfo);
                return back()->with('error', "Échec de l'envoi de la notification au client.");
            }
    
            return back()->with('success', "Notification envoyée au client ($prenom $nom) concernant « $objet ».");
        } catch (Exception $e) {
            \Log::error("Exception PHPMailer : " . $e->getMessage());
            return back()->with('error', "Erreur interne lors de l'envoi du mail : " . $e->getMessage());
        }
    }
    
    
    
    
}
