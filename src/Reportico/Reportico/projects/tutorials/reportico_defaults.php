<?php
/*
 Reportico - PHP Reporting Tool
 Copyright (C) 2010-2013 Peter Deed

 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License
 as published by the Free Software Foundation; either version 2
 of the License, or (at your option) any later version.
 
 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

 * File:        reportico_defaults.php
 *
 * This is the core Reportico Reporting Engine. The main 
 * reportico class is responsible for coordinating
 * all the other functionality in reading, preparing and
 * executing Reportico reports as well as all the screen
 * handling.
 *
 * @link http://www.reportico.co.uk/
 * @copyright 2010-2013 Peter Deed
 * @author Peter Deed <info@reportico.org>
 * @package Reportico
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @version : reportico.php,v 1.58 2013/04/24 22:03:22 peter Exp $
 */
    /*
     * Global reportico customization .. 
     * Set styles :-
     * Styles can be applied to the report body, details page, group headers, trailers, 
     * cell styles and are specified as a series of CSS like parameters.
     * Styles are applied to HTML and PDF formats
     * 
     * Add page headers, footers with styles to apply to every report page
     *
    */
    function reportico_defaults($reportico)
    {
            // Set up styles
            // Use 
            // $styles = array ( "styleproperty" => "value", .... );
            // $reportico->apply_styleset("REPORTSECTION", $styles, "columnname", WHENTOAPPLY );
            // Where REPORTSECTION is one of ALLCELLS ROW CELL PAGE BODY COLUMNHEADERS GROUPHEADER GROUPHEADERLABEL GROUPHEADERVALUE GROUPTRAILER
            // and WHENTOAPPLY can be PDF or HTML of leave unsepcified/false for both

            // Don't apply  apply body styles to pdf docuement when using fpdf engine
            if (  $reportico->pdf_engine != "fpdf" )
            {
                // REPORT BODY STYLES
                $styles = array(
                    //"background-color" => "#cccccc",
                    "border-width" => "1px 1px 1px 1px",
                    "border-style" => "solid",
                    "border-color" => "#333333",
                    //"background-color" => "#eeeeee",
                    //"padding" => "0 20 0 20",
                    //"margin" => "0 0 0 5",
                    "font-family" => "freesans",
                    );
                $reportico->apply_styleset("BODY", $styles, false, "PDF");

                // CRITERIA BOX STYLES
                $styles = array(
                    "background-color" => "#eeeeee",
                    "border-style" => "solid",
                    "border-width" => "1px 1px 1px 1px",
                    "border-color" => "#888888",
                    //"margin" => "0px 5px 10px 5px",
                    //"padding" => "0px 5px 0px 5px",
                    );
                $reportico->apply_styleset("CRITERIA", $styles, false, "HTML");

                $styles = array(
                    "display" => "none",
                    );
                $reportico->apply_styleset("CRITERIA", $styles, false, "PDF");
            }

            // PAGE DETAIL BOX STYLES
            $styles = array(
                "margin" => "0 2 0 2",
                );
            $reportico->apply_styleset("PAGE", $styles, false, "PDF");

            // DETAIL ROW BOX STYLES WITH ALTERNATING COLOURS 
            // Default all row lines to light grey
            $styles = array(
                "background-color" => "#fdfdfd",
                "margin" => "0 5 0 5",
                );
            $reportico->apply_styleset("ROW", $styles, false, "PDF");

            // Darker grey on every other line
            $styles = array(
                "background-color" => "#eeeeee",
                );
            $reportico->apply_styleset("ALLCELLS", $styles, false, "PDF", "lineno() % 2 == 0");


            //GROUP HEADER LABEL STYLES
            $styles = array(
                "margin" => "0 0 0 5",
                "width" => "3cm",
                "requires-before" => "8cm",
                );
            $reportico->apply_styleset("GROUPHEADERLABEL", $styles, false, "PDF");

            // GROUP HEADER VALUE STYLES
            $styles = array(
                "margin" => "0 20 0 0",
                );
            $reportico->apply_styleset("GROUPHEADERVALUE", $styles, false, "PDF");

            // ALL CELL STYLES
            /*
            $styles = array(
                "font-family" => "times",
                "border-width" => "1px 1px 1px 1px",
                "border-style" => "solid",
                "border-color" => "#888888",
                );
            $reportico->apply_styleset("ALLCELLS", $styles, false, "PDF");
            */

            // Specific named cell styles
            /*
            $styles = array(
                "color" => "#880000",
                "font-weight" => "bold",
                "font-style" => "italic",
                );
            $reportico->apply_styleset("CELL", $styles, "id", "PDF");
            */

            // Column header styles
            $styles = array(
                "color" => "#ffffff",
                "background-color" => "#999999",
                "font-weight" => "bold",
                );
            $reportico->apply_styleset("COLUMNHEADERS", $styles, false, "PDF");

            // Page Headers for TCPDF driver ( this is the default )
            if ( $reportico->pdf_engine == "tcpdf" )
            {
                // Create Report Title Page Header on every page of PDF
                $reportico->create_page_header("H1", 1, "{REPORT_TITLE}{STYLE border-width: 1 0 1 0; margin: 15px 0px 0px 0px; border-color: #000000; font-size: 18; border-style: solid;padding:5px 0px 5px 0px; height:1cm; background-color: #000000; color: #ffffff; text-align: center}" );
                $reportico->set_page_header_attribute("H1", "ShowInHTML", "no" );
                $reportico->set_page_header_attribute("H1", "ShowInPDF", "yes" );
                $reportico->set_page_header_attribute("H1", "justify", "center" );

                // Create Image on every page of PDF
                /*
                $reportico->create_page_header("H2", 1, "{STYLE width: 100; height: 50; margin: 0 0 0 0; background-color: #003333; background-image:images/reportico100.png;}" );
                $reportico->set_page_header_attribute("H2", "ShowInHTML", "no" );
                */

                // Create Image on every page of PDF
                $reportico->create_page_header("H3", 1, "Time: date('Y-m-d H:i:s'){STYLE font-size: 10; text-align: right; font-style: italic;}" );
                $reportico->set_page_header_attribute("H3", "ShowInHTML", "no" );
                $reportico->set_page_header_attribute("H3", "justify", "right" );

                // Create Page No on bottom of PDF page
                $reportico->create_page_footer("F1", 2, "Page: {PAGE}{STYLE border-width: 1 0 0 0; margin: 40 0 0 0; font-style: italic; }" );
            }
            else   // FPDF page headers
            {
                // Create Report Title Page Header on every page of PDF
                $reportico->create_page_header("H1", 2, "{REPORT_TITLE}{STYLE border-width: 1 0 1 0; margin: 15px 0px 0px 0px; border-color: #000000; font-size: 18; border-style: solid;padding:5px 0px 5px 0px; height:1cm; background-color: #000000; color: #ffffff}" );
                $reportico->set_page_header_attribute("H1", "ShowInHTML", "no" );
                $reportico->set_page_header_attribute("H1", "ShowInPDF", "yes" );
                $reportico->set_page_header_attribute("H1", "justify", "center" );

                // Create Image on every page of PDF
                $reportico->create_page_header("H3", 1, "Time: date('Y-m-d H:i:s'){STYLE font-size: 10; text-align: right; font-style: italic;}" );
                $reportico->set_page_header_attribute("H3", "ShowInHTML", "no" );
                $reportico->set_page_header_attribute("H3", "justify", "right" );

                // Create Page No on bottom of PDF page
                $reportico->create_page_footer("F1", 2, "Page: {PAGE}{STYLE border-width: 1 0 0 0; margin: 40 0 0 0; font-style: italic; }" );
            }
    }   
?>
