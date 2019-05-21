

<?php include 'includes/header.php';?>
<?php include 'includes/sidebar.php';?>
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Child Basic Info</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-sm-6">
								<h2>
									Child Details
								</h2>
							</div>
							<div class="col-sm-6 text-right">
								<a href="children.php" class="btn bg-blue-grey"> Go to child list</a>
							</div>
						</div>
					</div>
					<div class="body">
						<div class="form-common">
							<form action="" method="">
								<div class="other-info-form">
									<div class="row">
										<div class="col-sm-3	">
											<ul class="nav nav-tabs">
												<li class="active"><a data-toggle="tab" href="#Persoonsgegevens">Persoonsgegevens </a></li>
												<li><a data-toggle="tab" href="#gedragsociaal">Gedrag en Sociaal</a></li>
												<li><a data-toggle="tab" href="#medischemotioneel">Medisch en Emotioneel</a></li>
												<li><a data-toggle="tab" href="#Opvoedingsgegevens ">Opvoedingsgegevens </a></li>
												<li><a data-toggle="tab" href="#Andereinformatie">Andere informatie </a></li>
											</ul>
										</div>
										<div class="col-sm-9">
											<div class="tab-content">
												<div id="Persoonsgegevens" class="tab-pane fade in active">
													<h3>1. Persoonsgegevens </h3>
													<div class="form-group">
														<label>Datum intake *</label>
														<input type="text" class="datepicker form-control" required>
													</div>
													<div class="form-group">
														<p><b>Gezinssamenstelling</b></p>
														<div class="row">
															<div class="col-sm-6">
																<div class="form-group">
																	<label>Name</label>
																	<input type="text" class="form-control">
																</div>
															</div>
															<div class="col-sm-6">
																<div class="form-group">
																	<label>Relation with child *</label>
																	<select class="form-control show-tick">
																		<option value="">-- Please select --</option>
																		<option value="10">Son</option>
																		<option value="20">Daughter</option>
																		<option value="20">Other, Please specify below </option>
																	</select>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-sm-6">
																<div class="form-group">
																	<label>Name</label>
																	<input type="text" class="form-control">
																</div>
															</div>
															<div class="col-sm-6">
																<div class="form-group">
																	<label>Relation with child *</label>
																	<select class="form-control show-tick">
																		<option value="">-- Please select --</option>
																		<option value="10">Son</option>
																		<option value="20">Daughter</option>
																		<option value="20">Other, Please specify below </option>
																	</select>
																</div>
															</div>
														</div>
														<div class="form-group text-right">
															<a href="javascript:void(0)" class="btn bg-teal">Add More</a>
														</div>
														<div class="form-group">
															<label>Extra telefoonnummer(s) i.v.m. afwezigheid</label>
															<input type="text" class="form-control">
														</div>
													</div>
													<div class="form-group">
														<p><b>Opvang op de volgende dagen</b></p>
														<div class="row">
															<div class="col-sm-6">
																<div class="form-group">
																	<label>Opvang</label>
																	<input type="text" class="form-control">
																</div>
															</div>
															<div class="col-sm-6">
																<label>Date *</label>
																<input type="text" class="datepicker form-control" required>
															</div>
														</div>
														<div class="row">
															<div class="col-sm-6">
																<div class="form-group">
																	<label>Opvang</label>
																	<input type="text" class="form-control">
																</div>
															</div>
															<div class="col-sm-6">
																<label>Date *</label>
																<input type="text" class="datepicker form-control" required>
															</div>
														</div>
														<div class="form-group text-right">
															<a href="javascript:void(0)" class="btn bg-teal">Add More</a>
														</div>
													</div>
												</div>
												<div id="gedragsociaal" class="tab-pane fade">
													<h3>2. Speelwerkgedrag </h3>
													<div class="form-group">
														<div class="row">
															<div class="col-sm-6">
																<label><b>Zijn er dingen die uw kind graag doet? Zo ja,wat?</b></label>
															</div>
															<div class="col-sm-4">
																<input name="group5" id="radio_48" class="with-gap radio-col-blue-grey" type="radio"> 
															<label for="radio_48">ja</label>
															<input name="group5" id="radio_49" class="with-gap radio-col-blue-grey" type="radio"> 
															<label for="radio_49">nee</label>
															</div>
															
														</div>
														
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Waar speelt uw kind het liefst?</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group6" id="radio_50" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_50">Binnen</label>
														<input name="group6" id="radio_51" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_51">buiten</label>
														</div>
													</div>
														
														
													</div>
													<div class="form-group"><div class="row">
														<div class="col-sm-6">
														<label><b>Kan uw kind gericht en langere tijd met iets bezig zijn?</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group7" id="radio_52" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_52">ja</label>
														<input name="group7" id="radio_53" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_53">nee</label>
														</div>
													</div>
														
														<label>Geef alstublieft aan</label>
														<input type="text" class="form-control">
													</div>
													<h3>3. Sociale gegevens </h3>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Heeft het kind belangstelling voor anderen kinderen</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group8" id="radio_54" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_54">ja</label>
														<input name="group8" id="radio_55" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_55">nee</label>
														</div>
													</div>
														
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Gaat het kind op een prettige manier met leeftijdsgenoten om?</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group9" id="radio_56" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_56">ja</label>
														<input name="group9" id="radio_57" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_57">nee</label>
														</div>
													</div>
														
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Heeft het kind vriendjes/ vriendinnetjes ?</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group10" id="radio_58" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_58">ja</label>
														<input name="group10" id="radio_58" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_59">nee</label>
														</div>
													</div>
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Gaat het kind op een prettige manier met broertjes en zusjes om?</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group11" id="radio_60" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_60">ja</label>
														<input name="group11" id="radio_61" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_61">nee</label>
														</div>
													</div>
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Gaat het kind op een prettige manier met de ouder(s) / verzorger(s) om?</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group12" id="radio_62" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_62">ja</label>
														<input name="group12" id="radio_63" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_63">nee</label>
														</div>
													</div>
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Kan het kind zich in een ander verplaatsen?</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group13" id="radio_64" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_64">ja</label>
														<input name="group13" id="radio_65" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_65">nee</label>
														</div>
													</div>
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Heeft het kind vaak ruzie met anderen? Zo ja, wat is daar de (mogelijke) oorzaak van en hoe lost hij/zij dit op</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group14" id="radio_66" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_66">ja</label>
														<input name="group14" id="radio_67" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_67">nee</label>
														</div>
													</div>
														
														<label>Geef alstublieft aan</label>
														<input type="text" class="form-control">
													</div>
												</div>
												<div id="medischemotioneel" class="tab-pane fade">
													<h3>4. Medische gegevens </h3>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Is er sprake van bijzondere ziekten? Zo ja, wat moet de BSO daarvan weten?</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group15" id="radio_70" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_70">ja</label>
														<input name="group15" id="radio_71" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_71">nee</label>
														</div>
													</div>
														
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Is er sprake van allergieën? Zo ja welke, en op welke manier moet de BSO daar rekening mee houden?</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group16" id="radio_72" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_72">ja</label>
														<input name="group16" id="radio_73" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_73">nee</label>
														</div>
													</div>
														
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Zijn er problemen met de functie van de zintuigen?</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group17" id="radio_74" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_74">ja</label>
														<input name="group16" id="radio_75" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_75">nee</label>
														</div>
													</div>
														
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Is de motorische ontwikkeling normaal verlopen?</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group18" id="radio_76" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_76">ja</label>
														<input name="group18" id="radio_77" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_77">nee</label>
														</div>
													</div>
												
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Is uw kind zindelijk?</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group19" id="radio_78" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_78">ja</label>
														<input name="group19" id="radio_79" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_79">nee</label>
														</div>
													</div>
														
														
													</div>
													<h3>5. Emotionele gegevens </h3>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Kan het kind verschillende emoties uiten? Hoe uit hij/zij dat?</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group20" id="radio_80" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_80">ja</label>
														<input name="group20" id="radio_81" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_81">nee</label>
														</div>
													</div>
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>angst</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group21" id="radio_82" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_82">ja</label>
														<input name="group21" id="radio_83" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_83">nee</label>
														</div>
													</div>
														
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>blijheid</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group22" id="radio_84" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_84">ja</label>
														<input name="group22" id="radio_85" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_85">nee</label>
														</div>
													</div>
													
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>boosheid</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group23" id="radio_86" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_86">ja</label>
														<input name="group23" id="radio_87" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_87">nee</label>
														</div>
													</div>
														
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>verdriet</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group24" id="radio_88" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_88">ja</label>
														<input name="group24" id="radio_89" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_89">nee</label>
														</div>
													</div>
														
														
													</div>
												</div>
												<div id="Opvoedingsgegevens" class="tab-pane fade">
													<h3>6. Opvoedingsgegevens </h3>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Zijn er dingen in de opvoeding waar u regelmatig tegen aanloopt?</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group21" id="radio_90" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_90">ja</label>
														<input name="group21" id="radio_91" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_91">nee</label>
														</div>
													</div>
													
														
													</div>
													<h3>7. Taalontwikkeling </h3>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Is uw kind verstaanbaar?</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group22" id="radio_92" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_92">ja</label>
														<input name="group22" id="radio_93" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_93">nee</label>
														</div>
													</div>
														
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Begrijpt uw kind steeds wat u zegt?</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group23" id="radio_94" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_94">ja</label>
														<input name="group23" id="radio_95" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_95">nee</label>
														</div>
													</div>
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Heeft uw kind een voldoende woordenschat?</b></label>
														</div>
														<div class="col-sm-4">
															<input name="group24" id="radio_96" class="with-gap radio-col-blue-grey" type="radio"> 
															<label for="radio_96">ja</label>
															<input name="group24" id="radio_97" class="with-gap radio-col-blue-grey" type="radio"> 
															<label for="radio_97">nee</label>
														</div>
													</div>
														
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Spreekt uw kind makkelijk met anderen?</b></label>
														</div>
														<div class="col-sm-4">
														
														<input name="group25" id="radio_98" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_98">ja</label>
														<input name="group25" id="radio_99" class="with-gap radio-col-blue-grey" type="radio"> 
														<label for="radio_99">nee</label>
														</div>
													</div>
														
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
															<label><b>Stottert uw kind</b></label>
														</div>
														<div class="col-sm-4">
															<input name="group26" id="radio_100" class="with-gap radio-col-blue-grey" type="radio"> 
															<label for="radio_100">ja</label>
															<input name="group27" id="radio_101" class="with-gap radio-col-blue-grey" type="radio"> 
															<label for="radio_101">nee</label>
														</div>
													</div>
														
														
													</div>
												</div>
												<div id="Andereinformatie" class="tab-pane fade">
													<h3>8. Overige gegevens </h3>
													<div class="row">
														<div class="col-sm-6">
															<div class="form-group">
																<label>Nationaliteit kind</label>
																<input type="text" class="form-control">
															</div>
														</div>
														<div class="col-sm-6">
															<div class="form-group">
																<label>Soc./med. Indicatie</label>
																<input type="text" class="form-control">
															</div>
														</div>
														
													</div>
													<div class="row">
														<div class="col-sm-6">
															<div class="form-group">
																<label>Huisarts + tel.nr</b></label>
																<input type="text" class="form-control">
															</div>
														</div>
														<div class="col-sm-6">
															<div class="form-group">
																<label>Tandarts + tel. nr</label>
																<input type="text" class="form-control">
															</div>
														</div>
														
													</div>
													
													
													<h3>9. BSO </h3>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
															<label><b>Heeft het kind zin om naar de BSO te gaan?</b></label>
														</div>
														<div class="col-sm-4">
															<input name="group28" id="radio_1" class="with-gap radio-col-blue-grey" type="radio"> 
															<label for="radio_1">ja</label>
															<input name="group28" id="radio_2" class="with-gap radio-col-blue-grey" type="radio"> 
															<label for="radio_2">nee</label>
														</div>
													</div>
														
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
															<label><b>Bezoekt uw kind een peuterspeelzaal of kinderdagverblijf?</b></label>
														</div>
														<div class="col-sm-4">
															<input name="group28" id="radio_3" class="with-gap radio-col-blue-grey" type="radio"> 
															<label for="radio_3">ja</label>
															<input name="group28" id="radio_4" class="with-gap radio-col-blue-grey" type="radio"> 
															<label for="radio_4">nee</label>
														</div>
													</div>
														<br>
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
															<label><b>Kunnen wij t.z.t. een overdrachtsformulier tegemoet zien?</b></label>
														</div>
														<div class="col-sm-4">
															<input name="group28" id="radio_5" class="with-gap radio-col-blue-grey" type="radio"> 
															<label for="radio_5">ja</label>
															<input name="group28" id="radio_6" class="with-gap radio-col-blue-grey" type="radio"> 
															<label for="radio_6">nee</label>
														</div>
													</div>
														
														
													</div>
													<h3>10. Overige vragen/opmerkingen </h3>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
															<label><b>Hebt u nog aanvullende gegevens over uw kind?</b></label>
														</div>
														<div class="col-sm-4">
															<input name="group29" id="radio_7" class="with-gap radio-col-blue-grey" type="radio"> 
															<label for="radio_7">ja</label>
															<input name="group29" id="radio_8" class="with-gap radio-col-blue-grey" type="radio"> 
															<label for="radio_8">nee</label>
														</div>
													</div>
														
													</div>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
														<label><b>Zijn er kinderen met wie uw kind goed/graag speelt?</b></label>
														</div>
														<div class="col-sm-4">
															<input name="group30" id="radio_9" class="with-gap radio-col-blue-grey" type="radio"> 
															<label for="radio_9">ja</label>
															<input name="group30" id="radio_10" class="with-gap radio-col-blue-grey" type="radio"> 
															<label for="radio_10">nee</label>
														</div>
													</div>
														
													</div>
													<h3>11. Zorg </h3>
													<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
															<label><b>Bij zorg om het kind mag contact opgenomen worden met school?</b></label>
														</div>
														<div class="col-sm-4">
															<input name="group31" id="radio_11 class="with-gap radio-col-blue-grey" type="radio"> 
															<label for="radio_11">ja</label>
															<input name="group31" id="radio_12" class="with-gap radio-col-blue-grey" type="radio"> 
															<label for="radio_12">nee</label>
														</div>
													</div>
														
														
													</div>
													<h3>12. Wat verwachten ouders van BSO Bolderburen? </h3>
													<div class="form-group">
														<textarea class="form-control"></textarea>
													</div>
												</div>
												
												
											</div>
											<div class="form-group text-right m-t-20">
												<div class="cs-btn-group">
													<a href="basic-info.php" class="btn btn-lg bg-teal">Save</a>
													<a href="javascript:void(0)" class="btn btn-lg bg-orange">Cancel</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php include 'includes/footer.php';?>
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="../plugins/autosize/autosize.js"></script>
<!-- Moment Plugin Js -->
<script src="../plugins/momentjs/moment.js"></script>
<script src="../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<script src="../js/pages/forms/basic-form-elements.js"></script>
<script>
	function readURL(input) {
	          if (input.files && input.files[0]) {
	              var reader = new FileReader();
	
	              reader.onload = function (e) {
	                  $('#UplodImg')
	                      .attr('src', e.target.result)
	                      .width(150)
	                      .height(150);
	              };
	
	              reader.readAsDataURL(input.files[0]);
	          }
	      }
</script>

