<?php

    include_once('../../include.php');
    require_once('../../vendor/autoload.php');

    //class PDF extends FPDF {

    //     //-- Header ------------
    //     function Header() {

    //         // -- Défini l'anné et le numéro de la semaine pour calculer les informations de la semaines ----------------
    //         $anneeChoix = date('Y');
    //         $date_saisie = strtotime($_POST['dateSemaine']);
    //         $semChoix = date('W', $date_saisie);

    //         $timeStampPremierJanvier = strtotime($anneeChoix . '-01-01');
    //         $jourPremierJanvier = date('w', $timeStampPremierJanvier);
            
    //         //-- Recherche du N° de semaine du 1er janvier -------------------
    //         $numSemainePremierJanvier = date('W', $timeStampPremierJanvier);
            
    //         //-- Nombre à ajouter en fonction du numéro précédent ------------
    //         $decallage = ($numSemainePremierJanvier == 1) ? $semChoix - 1 : $semChoix;

    //         //-- Timestamp du jour dans la semaine recherchée ----------------
    //         $timeStampDate = strtotime('+' . $decallage . 'weeks', $timeStampPremierJanvier);
            
    //         //-- Recherche du lundi de la semaine en fonction de la ligne précédente ---------
    //         $jourDebutSemaine = ($jourPremierJanvier == 1) ? date('Y-m-d', $timeStampDate) : date('Y-m-d', strtotime('last monday', $timeStampDate));
    //         $jourFinSemaine = ($jourPremierJanvier == 1) ? date('Y-m-d', $timeStampDate) : date('Y-m-d',strtotime(' sunday', $timeStampDate));

    //         //-- Titre en gras avec une police et une taille ------------
    //         $this->SetFont('Helvetica', 'B', 11);

    //         //-- Fond de couleur Gris ------------
    //         $this->setFillColor(255, 0, 0);

    //         //-- Position du coin supérieur gauche par rapport à la marge gauche ------------
    //         $this->SetX(70);

    //         //-- Texte : 60 en largeur de ligne, 8 en hauteur de ligne, 0 pas de bordure, 1 retour à la ligne, Centre le texte, 1 couleur de fond ------------
    //         $this->Cell(60, 8, 'Clinique LPF', 0, 1, 'C', 1);
    //         $this->Ln(5);

    //         global $DB;

    //         $recupPrea = $DB->prepare('SELECT * FROM preadmission INNER JOIN personnel ON preadmission.idMedecin = personnel.id INNER JOIN operations ON preadmission.idOperation = operations.id WHERE personnel.service = ? AND operations.dateOperation >= ? AND operations.dateOperation <= ?;');
    //         $recupPrea->execute([$_POST['service'], $jourDebutSemaine, $jourFinSemaine]);
    //         $recupPreaFetch = $recupPrea->fetchAll();
    //         $recupPreaCount = $recupPrea->rowCount();

    //         $this->Cell(100, 10, mb_convert_encoding('Pré-admission disponible dans la semaine du ' . $_POST['dateSemaine'], 'windows-1252', 'UTF-8'), 0, 1, '', 0);

            
    //             if($recupPreaCount != 0) {
    //                 foreach($recupPreaFetch as $recupere) {
    //                     $this->Cell(100, 10, mb_convert_encoding($recupere['idPatient'] . ' ' . $recupere['nom'] . ' ' . $recupere['prenom'] . ' ' . $recupere['dateOperation'] . ' ' . $recupere['heureOperation'], 'windows-1252', 'UTF-8'), 0, 1, '', 0);
    //                     $this->Ln(5);
    //                 }
    //             } else {
    //                 $this->Cell(100, 10, mb_convert_encoding('Aucune pré-admission prévu dans cette semaine', 'windows-1252', 'UTF-8'), 0, 1, '', 0);
    //             }
    //         //-- Saut de ligne 10mm ------------
    //         $this->Ln(10);
    //     }

    //     //-- Footer ------------
    //     function Footer() {
    //         //-- Positionnement à 1,5cm du bas ------------
    //         $this->SetY(-15);

    //         //-- Police ------------
    //         $this->SetFont('Helvetica', 'I', 9);

    //         //-- Numéro de page, centré ------------
    //         $this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
    //     }
    // }


    // $pdf = new PDF('P', 'mm', 'A4');
    // $pdf->AddPage();

    // $pdf->SetFont('Helvetica', '', 9);
    // $pdf->SetTextColor(0);

    // $pdf->AliasNbPages();
    // $nomPdf = mb_convert_encoding('Préadmission de la semaine du ' . $_POST['dateSemaine'].'.pdf', 'windows-1252', 'UTF-8');
    // $pdf->Output('I', $nomPdf);
    
    // Créez une nouvelle instance de TCPDF   
    //}


    require_once('../../vendor/tecnickcom/tcpdf/tcpdf.php');

    class MyPDFGenerator {

        private $erreur = '';

        public function generatePDF() {
            extract($_POST);
        
            if(empty($dateSemaine)) {
                if($service == 'aucun') {
                    header('Location: ../pdf_semaine.php');
                    exit;
                }
            }
            
            global $DB;
            // Crée une instance de la classe TCPDF
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            
            $anneeChoix = date('Y');
            $date_saisie = strtotime($_POST['dateSemaine']);
            $semChoix = date('W', $date_saisie);

            $timeStampPremierJanvier = strtotime($anneeChoix . '-01-01');
            $jourPremierJanvier = date('w', $timeStampPremierJanvier);
            
            //-- Recherche du N° de semaine du 1er janvier -------------------
            $numSemainePremierJanvier = date('W', $timeStampPremierJanvier);
            
            //-- Nombre à ajouter en fonction du numéro précédent ------------
            $decallage = ($numSemainePremierJanvier == 1) ? $semChoix - 1 : $semChoix;

            //-- Timestamp du jour dans la semaine recherchée ----------------
            $timeStampDate = strtotime('+' . $decallage . 'weeks', $timeStampPremierJanvier);
            
            //-- Recherche du lundi de la semaine en fonction de la ligne précédente ---------
            $jourDebutSemaine = ($jourPremierJanvier == 1) ? date('Y-m-d', $timeStampDate) : date('Y-m-d', strtotime('last monday', $timeStampDate));
            $jourFinSemaine = ($jourPremierJanvier == 1) ? date('Y-m-d', $timeStampDate) : date('Y-m-d',strtotime(' sunday', $timeStampDate));

            $recupPrea = $DB->prepare('SELECT * FROM preadmission INNER JOIN personnel ON preadmission.idMedecin = personnel.id INNER JOIN operations ON preadmission.idOperation = operations.id INNER JOIN patient on preadmission.idPatient = patient.numSecu WHERE personnel.service = ? AND operations.dateOperation >= ? AND operations.dateOperation <= ?');
            $recupPrea->execute([$_POST['service'], $jourDebutSemaine, $jourFinSemaine]);
            $recupPreaFetch = $recupPrea->fetchAll();
            $recupPreaCount = $recupPrea->rowCount();

            
            
            
            // Définissez les propriétés de votre PDF
            $pdf->SetCreator('CliniqueLPF');
            $pdf->SetAuthor('Moi-même');
            $pdf->SetTitle('Pré-admission de la semaine du ' . $_POST['dateSemaine']);
            $pdf->SetSubject('Toutes les préadmissions de la semaine du ' . $_POST['dateSemaine']);
            $pdf->SetKeywords('PDF, formulaire, TCPDF');
            
            // Ajoutez une page à votre PDF
            $pdf->AddPage();
            
            // Ajoutez du texte à votre PDF
            $pdf->SetFont('times', 'BI', 20);
            $pdf->Cell(0, 10, 'CliniqueLPF - Semaine du ' . $_POST['dateSemaine'], 0, 1, 'C');
            
            // Ajoutez un champ de texte à votre PDF
            $pdf->SetFont('times', '', 12);
            
            if($recupPreaCount != 0) {
                foreach($recupPreaFetch as $recupere) {
                    $id = $recupere['id']; // Identifiant unique pour chaque enregistrement
                    $pdf->Cell(0, 10, 'Nom et prénom : ', 0, 1);
                    $pdf->TextField('nom_' . $id, 50, 10, array('value' => $recupere['nomNaissance'] . ' ' . $recupere['prenom']));
                    $pdf->Ln(2);
                }
            } else {
                $pdf->Cell(0, 10, 'Aucune préadmission dans la semaine du ' . $_POST['dateSemaine'], 0, 1, 'C');
            }

            
            // Enregistrez et affichez votre PDF
            $pdf->Output('formulaire.pdf', 'I');
        }
    }



    // Utilise la classe pour générer un PDF
    $generator = new MyPDFGenerator();
    $generator->generatePDF();

?>