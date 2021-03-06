<?php
//pr($purtoBill['scheme']['scheme_contractors'][0]['contractor']['contractor_title']);die;
//pr($purtoBill);die;
?>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Purto Bills'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Chalan Form') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Purto Bills'), ['action' => 'index']) ?> </li>

        <li class="active"><?= $this->Html->link(__('Generate Chalan Form'), ['action' => 'view', $purtoBill['id']
            ]) ?>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="tabbable">
            <ul class="nav nav-pills">
                <li class="active"><a data-toggle="tab" href="#front_page"><?= __('Front Page') ?></a></li>
                <li><a data-toggle="tab" href="#back_page"><?= __('Back Page') ?></a></li>
                <li><a data-toggle="tab" href="#bill-form"><?= __('Bill Form') ?></a></li>
                <?php if (isset($purtoBill['security'])) { ?>
                    <li><a data-toggle="tab" href="#security"><?= __('Security') ?></a></li>
                <?php } ?>

                <?php if (isset($purtoBill['vat'])) { ?>
                    <li><a data-toggle="tab" href="#vat"><?= __('Vat') ?></a></li>
                <?php } ?>

                <?php if (isset($purtoBill['cost_of_material'])) { ?>
                    <li><a data-toggle="tab" href="#cost_of_material"><?= __('Cost Of Material') ?></a></li>
                <?php } ?>

                <?php if (isset($purtoBill['income_tex'])) { ?>
                    <li><a data-toggle="tab" href="#income_taxes"><?= __('Income Tax') ?></a></li>
                <?php } ?>

                <?php if (isset($purtoBill['hire_charge'])) { ?>
                    <li><a data-toggle="tab" href="#roller_charge"><?= __('Roller Charge') ?></a></li>
                <?php } ?>

                <?php if (isset($purtoBill['lab_fee'])) { ?>
                    <li><a data-toggle="tab" href="#lab_fee"><?= __('Lab Fee') ?></a></li>
                <?php } ?>

                <?php if (isset($purtoBill['fine'])) { ?>
                    <li><a data-toggle="tab" href="#fine"><?= __('Fine') ?></a></li>
                <?php } ?>

                <?php if (isset($purtoBill['etc_fee'])) { ?>
                    <li><a data-toggle="tab" href="#etc_fee"><?= __('Etc') ?></a></li>
                <?php } ?>
            </ul>

            <div class="tab-content pill-content">
                <div id="front_page" class="tab-pane fade in active">
                    <div class="col-sm-12">
                        <button class="btn btn-xs btn-warning icon-print2" style="float: right;margin-bottom: 10px"
                                onclick="print_rpt('PrintArea')">&nbsp;<?= __('Print') ?>
                        </button>
                    </div>
                    <div id="PrintArea" class="" style="margin-bottom: 40px">
                        <div class="col-sm-12">
                            <p><?= __('টি আর ফরম নং ২১') ?></p>

                            <p><?= __('(এস, আর ১৮৩ দ্রষ্টব্য)') ?></p>
                        </div>
                        <div class="col-sm-12">
                            <h3 class="text-center"><?= __('ক্রয়, সরবরাহ ও সেবা বাবদ ব্যয়ের বিল') ?></h3>

                            <h3 class="text-center"><?= __('দপ্তর- নির্বাহী প্রকৌশলীর দপ্তর, এলজিইডি, গাজীপুর') ?></h3>
                        </div>

                        <div class="col-sm-12">
                            <table class="table top-table">
                                <tr>
                                    <td width="20%"><?= __('কোড নং') ?></td>
                                    <td colspan="3">
                                        <table class="text-center">
                                            <tr>
                                                <td class="border"></td>
                                                <td>--</td>
                                                <td class="border"></td>
                                                <td class="border"></td>
                                                <td class="border"></td>
                                                <td class="border"></td>
                                                <td>--</td>
                                                <td class="border"></td>
                                                <td class="border"></td>
                                                <td class="border"></td>
                                                <td class="border"></td>
                                                <td>--</td>
                                                <td class="border"></td>
                                                <td class="border"></td>
                                                <td class="border"></td>
                                                <td class="border"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?= __('টোকেন নং ...........................................') ?></td>
                                    <td><?= __('তারিখ ............................................................................') ?></td>
                                    <td><?= __('ভাউচার নং ......................................................................') ?></td>
                                    <td><?= __('তারিখ ...............................................................') ?></td>
                                </tr>
                            </table>
                            <style>
                                .table.top-table {
                                    border-bottom: 0px;
                                }

                                .table.top-table th, .table.top-table td {
                                    border: 0px;
                                }

                                .fixed-table-container {
                                    border: 0px !important;
                                }

                                .border {
                                    border: 1px solid #2C3A42 !important;
                                    width: 40px;
                                    height: 40px
                                }

                                .para {
                                    line-height: 20px
                                }
                            </style>
                        </div>
                        <div class="col-sm-12" style="margin: 20px 0">
                            <table class="table table-bordered text-center">
                                <tr>
                                    <td><?= __('অর্থনৈতিক কোড ') ?></td>
                                    <td><?= __('সরবরাহকৃত দ্রব্যের বিবরণ') ?></td>
                                    <td width="35%" colspan="2"><?= __('পরিমাণ') ?></td>
                                </tr>
                                <tr>
                                    <td><?= $this->Number->format('7031') ?></td>
                                    <td></td>
                                    <td><?= __('টাকা') ?></td>
                                    <td width="8%"><?= __('পঃ') ?></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><?= $purtoBill['bill_type'] ?></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><?= $purtoBill['scheme_name'] ?></td>
                                    <td><?= $this->Number->format($purtoBill['bill_amount']) ?></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <?php if (isset($purtoBill['security'])) { ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><?= __('Security') ?> = <?= $this->Number->format($purtoBill['security']) ?></td>
                                        <td> </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if (isset($purtoBill['vat'])) { ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><?= __('Vat') ?> = <?= $this->Number->format($purtoBill['vat']) ?></td>
                                        <td></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if (isset($purtoBill['income_tex'])) { ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><?= __('Income Tax') ?> = <?= $this->Number->format($purtoBill['income_tex']) ?></td>
                                        <td></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if (isset($purtoBill['hire_charge'])) { ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><?= __('Roller Charge') ?> = <?= $this->Number->format($purtoBill['hire_charge']) ?></td>
                                        <td></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if (isset($purtoBill['lab_fee'])) { ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><?= __('Lab Fee') ?> = <?= $this->Number->format($purtoBill['lab_fee']) ?></td>
                                        <td></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <?php if (isset($purtoBill['fine'])) { ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><?= __('Fine') ?> = <?= $this->Number->format($purtoBill['fine']) ?></td>
                                        <td></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td></td>
                                    <td> <?php echo __('মোট কর্তন')?></td>
                                    <?php $total_cut = $purtoBill['security'] + $purtoBill['vat'] + $purtoBill['income_tex'] + $purtoBill['hire_charge'] + $purtoBill['lab_fee'] + $purtoBill['fine']?>
                                    <td><?= $this->Number->format($total_cut)?></td>
                                    <td></td>
                                </tr>
                                <?php if (isset($purtoBill['net_payable'])) { ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><?= __('নীট টাকা') ?></td>
                                        <td><?= $this->Number->format($purtoBill['net_payable']) ?></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                </tr>


                            </table>
                        </div>
                        <div class="col-sm-12 para">
                            <p>১। প্রত্যয়ন করা যাইতেছে যে, জনস্বার্থে এই ব্যয় অপরিহার্য। আমি আরও প্রত্যায় করিতেছি যে,
                                আমার
                                জানা ও বিশ্বাস
                                মতে, এই বিলের উল্লেখিত প্রদত্ত নিম্নবর্ণিত ক্ষেত্র ব্যতীত প্রকৃত প্রাপককে প্রদান করা
                                হইয়াছে,
                                তবে স্থায়ী
                                অগ্রিমের টাকা অপেক্ষা দায় বেশি হওয়ার, অবশিষ্ট পাওনা এই বিলে দাবিকৃত টাকা প্রাপ্তির পর
                                প্রদান
                                করা হইবে। আমি
                                যথাসম্ভব সকল ভাউচার গ্রহণ করিয়াছি এবং সেগুলি এমনভাবে বাতিল করা হইয়াছে যেন পুনরায় ব্যবহার
                                করা
                                না যায়। ২৫
                                টাকার উর্দ্ধের সকল ভাউচারসমূহ এমনভাবে সংরক্ষণ করা হইয়াছে, যেন প্রয়োজনমত ৩ বৎসরের মধ্যে
                                এইগুলি পেশ করা যায়।
                                সকল পূর্ত কর্মের বিল সঙ্গে সংযুক্ত করা হইল।</p>

                            <p>২। প্রত্যায়ন করা যাইতেছে যে, যে সকল দ্রব্যের জন্য স্টোর একাউন্টস সংরক্ষন করা হয় সে সব
                                দ্রব্যাদি স্টক
                                রেজিস্টারে অন্তর্ভুক্ত করা হইয়াছে।</p>

                            <p>৩। প্রত্যায়ন করা যাইতেছে যে, যে সব দ্রব্যাদি ক্রয়ের বিল পেশ করা হইয়াছে, সে সব দ্রব্যের
                                পরিমাণ
                                সঠিক গুনগতমান
                                ভাল, যে দরে ক্রয় করা হইয়াছে, তাহা বাজার দরের অধিক নহে, এবং কার্যাদেশ বা চালানে (ইনভয়েস)
                                এর
                                যথাস্থানে
                                লিপিবদ্ধ করা হইয়াছে। যাহাতে একই দ্রব্যের জন্য দ্বিতীয় বার (ডুপ্লিকেট) অর্থ প্রদান এড়ান
                                যায়।</p>

                            <p>৪। প্রত্যায়ন করা যাইতেছে যে-
                            <ul style="list-style: none">
                                <li>(ক)&nbsp; এই বিলে দাবিকৃত পরিবহণ ভাড়া প্রকৃতপক্ষে দেওয়া হইয়াছে এবং ইহা অপরিহার্য ছিল
                                    এবং
                                    ভাড়ার হার
                                    প্রচলিত
                                    যানবাহন ভাড়ার হারের মধ্যেই; এবং
                                </li>
                                <li>(খ)&nbsp; সংশ্লিষ্ট সরকারী কর্মচারী সাধারণ বিধি বলে এই ভ্রমণের জন্য ব্যয় প্রাপ্য হন
                                    না,
                                    এবং এর অতিরিক্ত
                                    কোন
                                    বিশেষ পারিশ্রমিক, এই দায়িত্ব পালনের জন্য প্রাপ্য হইবেন না।
                                </li>
                            </ul>
                            </p>

                        </div>
                    </div>
                </div>
                <div id="back_page" class="tab-pane fade">
                    <div class="col-sm-12">
                        <button class="btn btn-xs btn-warning icon-print2" style="float: right;margin-bottom: 10px"
                                onclick="print_rpt('PrintBackPage')">&nbsp;<?= __('Print') ?>
                        </button>
                    </div>
                    <div id="PrintBackPage" class="" style="margin-bottom: 40px">
                        <div class="col-sm-12 para">
                            <p>৫। প্রত্যায়ন করা যাইতেছে যে, যে সকল অধঃস্তন কর্মচারীর বেতন এই বিলে দাবী করা হইয়াছে তাহারা
                                ঐ সময়ে প্রকৃতই সরকারী কাজে নিয়োজিত ছিলেন (এস, আর, ১৭১)। </p>

                            <p>৬। প্রত্যায়ন করা যাইতেছে যে,
                            <ul style="list-style: none">
                                <li>(ক)মনোহারী দ্রব্য বা স্ট্যম্প বাবদ ২০ টাকার অধিক কোন ক্রয় স্থানীয়ভাবে করা হয় নাই।
                                </li>
                                <li>(খ)ব্যাক্তিগত কাজে ব্যবহৃত তাবু বহনের কোন খরচ এই বিলে অন্তর্ভুক্ত করা হয় নাই।</li>
                                <li>(গ)আবাসিক ভবনে ব্যবহৃত কোন বিদ্যুৎ বাবদ খরচ এই বিলে অন্তর্ভুক্ত করা হয় নাই।</li>
                                <li>(ঘ) এই বৎসরে প্রসেস প্রদত্ত পারিতোষিক
                                    টাকা <?= $this->Number->format('0') ?>/-
                                    (................................................................................................................................................................................)।
                                </li>
                                <li>৭। যাহার নামে চেক ইস্যু করা হইবে (প্রযোজ্য
                                    ক্ষেত্রে) <?= $purtoBill['contractor_name'] ?></li>
                            </ul>
                            </p>
                        </div>
                        <div class="col-sm-12">
                            <table class="table back-table">
                                <tr>
                                    <td><?= __('*নিয়ন্ত্রণকারী/প্রতিস্বাক্ষরকারী কর্মকর্তার স্বাক্ষর') ?></td>
                                    <td><?= __('বুঝিয়া পাইয়াছি.......................................................................................................................................') ?></td>
                                </tr>
                                <tr>
                                    <td><?= __('.................................................................................................................................................') ?></td>
                                    <td><?= __('আয়ন কর্মকর্তার স্বাক্ষর ..........................................................................................................................') ?></td>
                                </tr>
                                <tr>
                                    <td><?= __('নাম ..........................................................................................................................................') ?></td>
                                    <td><?= __('নাম .........................................................................................................................................................') ?></td>
                                </tr>
                                <tr>
                                    <td><?= __('পদবী .......................................................................................................................................') ?></td>
                                    <td><?= __('পদবী .......................................................................................................................................................') ?></td>
                                </tr>

                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td><?= __('সীল') ?></td>
                                    <td><?= __('সীল') ?></td>
                                </tr>
                                <tr>
                                    <td><?= __('স্থান...........................................................................................................................................') ?></td>
                                    <td><?= __('স্থান.........................................................................................................................................................') ?></td>
                                </tr>
                                <tr>
                                    <td><?= __('তারিখ ......................................................................................................................................') ?></td>
                                    <td><?= __('তারিখ .....................................................................................................................................................') ?></td>
                                </tr>


                            </table>

                            <style>
                                .table.back-table {
                                    border-bottom: 0px;
                                }

                                .table.back-table th, .table.back-table td {
                                    border: 0px;
                                    width: 50%;
                                }

                                .fixed-table-container {
                                    border: 0px !important;
                                }

                                .border {
                                    border: 1px solid #2C3A42 !important;
                                    width: 40px;
                                    height: 40px
                                }

                                .para {
                                    line-height: 20px
                                }
                            </style>
                        </div>
                        <div class="col-sm-6">
                            <table class="table table-bordered">
                                <tr>
                                    <td><?= __('বরাদ্দের হিসাব') ?></td>
                                    <td width="25%"><?= __('টাকা') ?></td>
                                    <td width="8%"><?= __('পঃ') ?></td>
                                </tr>

                                <tr>
                                    <td><?= __('১। শেষ বিলের টাকার অংক') ?></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><?= __('২। এ যাবত অতিরিক্ত বরাদ্দ(পত্র নং.........)') ?></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><?= __('৩। এ যাবত যে অংকের বরাদ্দ কমানো হইয়াছে। (পত্র নং.........)') ?></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><?= __('৪। নীট মোট') ?></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <table class="table table-bordered">
                                <tr>
                                    <td><?= __('বরাদ্দের হিসাব') ?></td>
                                    <td width="25%"><?= __('টাকা') ?></td>
                                    <td width="8%"><?= __('পঃ') ?></td>
                                </tr>

                                <tr>
                                    <td><?= __('গত বিলের মোট জের(+)') ?></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><?= __('এই বিলের মোট(+)') ?></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><?= __('সংযুক্ত- পুর্তকর্মের বিলের টাকা') ?></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><?= __('মোট (পরবর্তী বিলে জের টানিয়া নেওয়া হইবে)। ') ?></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>

                        </div>
                        <div class="col-sm-12">
                            <hr style="border-top: 2px solid #2C3A42">
                        </div>
                        <div class="col-sm-12">
                            <h4 class="text-center"><?= __('হিসাব রক্ষণ অফিসে ব্যবহারের জন্য') ?></h4>

                            <p><?= __('প্রদানের জন্য পাস করা হইল টাকা .........................................................................................................................  কথায় ..........................................................................................................................................................') ?></p>

                            <div class="col-sm-12">
                                <table class="table sign-table">
                                    <tr>
                                        <td><?= __('অডিটর(স্বাক্ষর)') ?></td>
                                        <td><?= __('সুপার(স্বাক্ষর)') ?></td>
                                        <td><?= __('হিসাব রক্ষণ অফিসার(স্বাক্ষর)') ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('নাম ...............................................................................................') ?></td>
                                        <td><?= __('নাম ...............................................................................................') ?></td>
                                        <td><?= __('নাম ...............................................................................................') ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('তাং ................................................................................................') ?></td>
                                        <td><?= __('তাং ................................................................................................') ?></td>
                                        <td><?= __('তাং ................................................................................................') ?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><?= __('চেক নং .........................................................................................') ?></td>
                                        <td><?= __('তারিখ ............................................................................................') ?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><?= __('চেক প্রদানকারীর স্বাক্ষর') ?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><?= __('নাম ...............................................................................................') ?></td>
                                    </tr>

                                </table>
                                <style>
                                    .table.sign-table {
                                        border-bottom: 0px;
                                    }

                                    .table.sign-table th, .table.sign-table td {
                                        border: 0px;
                                        width: 33.33%;
                                    }

                                    .fixed-table-container {
                                        border: 0px !important;
                                    }

                                    .border {
                                        border: 1px solid #2C3A42 !important;
                                        width: 40px;
                                        height: 40px
                                    }

                                    .para {
                                        line-height: 20px
                                    }
                                </style>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <p>* কেবলমাত্র প্রযোজ্য ক্ষেত্রে।
                            <ul style="list-style: none">
                                <li>বিঃদ্রঃ- ইহা স্পষ্টভাবে স্মরণ রাখিতে হইবে যে, বরাদ্দের অতিরিক্ত ব্যায়ের জন্য আয়ন
                                    কর্মকর্তা ব্যক্তিগতভাবে দায়ী থাকিবেন। বরাদ্দের অতিরিক্ত ব্যয়ের বিপরীতে যদি তিনি
                                    অতিরিক্ত
                                    বরাদ্দ মঞ্জুর করাইতে না পারেন, তবে অতিরিক্ত ব্যয়িত অর্থ তাহার ব্যক্তিগত ভাতাদি
                                    হইতে আদায়
                                    করা হইবে।
                                </li>
                            </ul>

                            </p>
                            <p>
                                বাঃসঃমুঃ-৯৭/৯৮ ১৮০৪৫ (কম-১) ৩০ লক্ষ কপি (সি-৬৩)১৯৯৮।
                            </p>
                        </div>
                    </div>
                </div>
                <div id="bill-form" class="tab-pane fade">
                    <div class="col-sm-12">
                        <button class="btn btn-xs btn-warning icon-print2" style="float: right;margin-bottom: 10px"
                                onclick="print_rpt('bill-report')">&nbsp;<?= __('Print') ?>
                        </button>
                    </div>
                    <div id="bill-report" class="" style="margin-bottom: 40px">
                        <div class="col-sm-12">
                            <h2 style="text-align: center"><u>LOCAL GOVT. ENGINEERING DEPARTMENT</u></h2>
                            <h4 style="text-align: center;">FINAL ACCOUNT BILL FORM</h4>
                        </div>
                        <div class="col-sm-12">
                            <table style="width: 100%">
                                <tr>
                                    <td width="50%" style="text-align: center"> District: <?= $purtoBill['district']?$purtoBill['district']:'' ?></td>
                                    <td width="50%" style="text-align: center">Thana: <?= $purtoBill['upazila']?$purtoBill['upazila']:'' ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-12">
                            <table>
                                <tr style="overflow: hidden; border-top: 1px solid #000; border-bottom: 1px solid #000">
                                    <td style="width: 50%; border-right: 1px solid #000; padding:5px 20px 20px 20px; vertical-align: top">
                                        <div class="fix" style="border-bottom: 1px solid #000">
                                            NOTES:
                                            <ol class="d-report" style="padding-left: 15px !important;">
                                                <li>Wwks Should Promptly measured Up and paid.</li>
                                                <li>When the payee signs in the vernacular, the amount acknowledge-3d, should also be noted in vernacular as well as in English.</li>
                                                <li>In the case of payees who can neither read nor write the payee, shall nark or impress his seal. Fact of the payment shall be certified to by the officer who pays’ and by a witness of respect ability</li>
                                                <li>It  the bill is prepared by the Officer authorized to make payment order a signature will be sufficient.</li>
                                                <li>A receipt stamp is required for every payment exceeding Tk.  20/00.</li>
                                                <li>IVe amount acknowledge as received by the contractor, must be entered words and figures</li>
                                                <?php if($purtoBill['bill_type_check'] == 2): ?>
                                                <li>This form will not be used for payment of running bill</li>
                                                <?php endif; ?>
                                            </ol>
                                        </div>
                                        <div class="fix signature" style="margin-bottom: 0.5em;">
                                            <div>
                                                <ol style="margin-top: 1em; padding-left: 15px !important;">
                                                    <li>Certify that all necessary checks are duly done and the work is completed satisfactorily,</li>
                                                </ol>
                                            </div>
                                            <div class="text-center" style="margin-bottom: 0.5em ">
                                                <span>PASSED FOR</span>
                                            </div>
                                            <div style="margin-bottom: 4em; line-height: 3em">
                                                <p>Tk. .............................................................................................<br>
                                                ..................................................................................................</p>
                                            </div>
                                            <div style="border-top: 1px solid #000">
                                                <table width="100%">
                                                    <tr>
                                                        <td width="50%"><?= __('Account') ?></td>
                                                        <td width="50%" style="text-align: right; padding-right: 1.5em"><?= __('Executive Engineer/') ?><br><?= __('Thana Engineer') ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="pay-tk" style="border-top: 1px solid #000; margin-top: 1.5em; line-height: 3em">
                                                <p>Pay Tk. .........................................................................................<br>
                                                ..................................................................................................</p>
                                            </div>
                                            <div style="border-top: 1px solid #000; margin-top: 3em">
                                                <table width="100%">
                                                    <tr>
                                                        <td width="50%"><?= __('Account') ?></td>
                                                        <td width="50%" style="text-align: right; padding-right: 1.5em "><?= __('Executive Engineer/') ?><br><?= __('Thana Engineer') ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td  style="width: 50%; padding:5px 20px 20px 20px; vertical-align: top">
                                        <div class="info-scheme">
                                            <p>HEAD CHARGEABLE: </p>
                                            <p>Name Of Work: <?= $purtoBill['scheme_name'] ?></p>
                                            <p>Name Of Contractor: <?= $purtoBill['contractor_name'] ?> </p>
                                            <p>Tender No: <? $purtoBill['etender_no'] ?> </p>
                                        </div>
                                        <div class="date-info" style="border-top: 1px solid #000">
                                            <table width="100%" style="line-height: 29px;">
                                                <tr>
                                                    <td width="50%">Date of commencement:</td>
                                                    <td width="50%"><?= $purtoBill['do_commencement']?date('d-m-Y', $purtoBill['do_commencement']):'' ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%">Date of completion:</td>
                                                    <td width="50%"><?= $purtoBill['do_completion']?date('d-m-Y', $purtoBill['do_completion']):'' ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%">Extended date of completion:</td>
                                                    <td width="50%"><?= $purtoBill['edo_completion']?date('d-m-Y', $purtoBill['edo_completion']):'' ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%">Actual date of completion:</td>
                                                    <td width="50%"><?= $purtoBill['ado_completion']?date('d-m-Y', $purtoBill['ado_completion']):'' ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="others-amount"  style="border-top: 1px solid #000">
                                            <table width="100%" style="line-height: 29px;">
                                                <tr>
                                                    <td width="50%">Original approved estimate:</td>
                                                    <td width="50%">Tk <?= $purtoBill['contract_amount']?></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%">Revised approved estimate:</td>
                                                    <td width="50%">Tk</td>
                                                </tr>
                                                <tr>
                                                    <td width="50%">Extenditure:</td>
                                                    <td width="50%">Tk</td>
                                                </tr>
                                                <tr>
                                                    <td width="50%">Difference:</td>
                                                    <td width="50%">Tk</td>
                                                </tr>
                                                <tr>
                                                    <td width="50%">Percentage of excess:(if any)</td>
                                                    <td width="50%">Tk</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="main-info" style="border-top: 1px solid #000">
                                            <table width="100%" style="line-height: 29px;">
                                                <tr style="margin-bottom: 1em;">
                                                    <td  width="50%"><u>1. Bill amount:</u></td>
                                                    <td  width="50%">Tk <?= $purtoBill['bill_amount'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td  colspan="2" style="padding-top: 1em">Deduction:</td>
                                                </tr>
                                                <tr>
                                                    <td  width="50%">(A) Income Tax:</td>
                                                    <td  width="50%">Tk <?= $purtoBill['income_tex']?></td>
                                                </tr>
                                                <tr>
                                                    <td  width="50%">(B) Cost of Materials:<br> (if issued): </td>
                                                    <td  width="50%" style="vertical-align: top;">Tk <?= $purtoBill['cost_of_material']?></td>
                                                </tr>
                                                <tr>
                                                    <td  width="50%">(C) Hire Charges of Equipment (if any):</td>
                                                    <td  width="50%" style="vertical-align: top">Tk <?= $purtoBill['hire_charge']?></td>
                                                </tr>
                                                <tr>
                                                    <td  width="50%">(D) Lab Fee</td>
                                                    <td  width="50%" style="vertical-align: top">Tk <?= $purtoBill['lab_fee']?></td>
                                                </tr>
                                                <tr>
                                                    <td  width="50%">(E) Security: </td>
                                                    <td  width="50%">Tk <?= $purtoBill['security'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td  width="50%">(F) Vat</td>
                                                    <td  width="50%">Tk <?= $purtoBill['vat']?></td>
                                                </tr>
                                                <tr>
                                                    <td  width="50%">(G) Etc.</td>
                                                    <td  width="50%">Tk <?= $purtoBill['etc_fee']?></td>
                                                </tr>
                                                <?php if(!empty($purtoBill['e_field']) && !empty($purtoBill['e_value'])):?>
                                                    <tr>
                                                        <td  width="50%">(H) <?= $purtoBill['e_field'] ?></td>
                                                        <td  width="50%">Tk <?= $purtoBill['e_value']?></td>
                                                    </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td  width="50%" ><span style="padding-left: -5px"> Total Deduction</span></td>
                                                    <td  width="50%">Tk <?= $deduction = $purtoBill['income_tex'] + $purtoBill['cost_of_material'] + $purtoBill['hire_charge'] + $purtoBill['security'] + $purtoBill['vat'] + $purtoBill['etc_fee'] + $purtoBill['lab_fee'] + $purtoBill['e_value'] ?></td>
                                                </tr>
                                                <tr >
                                                    <td  width="50%" style="padding-top: 1em"><u>2. Payable amount:</u></td>
                                                    <td  width="50%"  style="padding-top: 1.5em">Tk <?= $net_payable = $purtoBill['bill_amount'] - $deduction ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="receive-amount" style="border-top: 1px solid; margin-top: 1em; line-height: 33px;">
                                            <p style="line-height: 17px;">Received payment of Tk. ......................................................................................... as per detail on account in full satisfaction of all my demands.</p>
                                        </div>
                                        <div class="bottom-design">
                                            <table width="100%">
                                                <tr>
                                                    <td width="70%">
                                                        <p style="margin-bottom: 0">.................................</p>
                                                        Contractor<br><br>
                                                        <p style="margin-bottom: 0">..................................</p>
                                                        Witness
                                                    </td>
                                                    <td width="30%">
                                                        <p class="stamp">Stamp</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-12">
                            <p style="padding-left: 1em">Those words should be scored out in all cases –except when payment is made to a person who can neither read nor write.</p>
                        </div>
                        <style>
                            .d-report li{
                                margin-bottom: 18px;
                                line-height: 25px;
                            }
                            .stamp{
                                border: 1px solid;
                                width: 86px;
                                padding: 20px;
                                text-align: center;
                            }
                            table, table tr td{
                                font-family: "Times New Roman";
                            }
                            body{
                                font-family: "Times New Roman"
                                font-size: 20px;
                            }
                            .tablesorter {
                                font-size: 16px;
                                text-align: left;
                            }

                            table tr thead th {
                                background-color: #FAFAFA;
                                font-size: 15px !important;
                            }
                            table tr td {
                                font-size: 15px !important;
                                font-family: '"Times New Roman";
                            }
                            p {
                                margin: 0 0 7px;
                            }
                        </style>
                    </div>
                </div>
                <?php if (isset($purtoBill['security'])) { ?>
                    <div id="security" class="tab-pane fade">
                        <div class="col-sm-12">
                            <button class="btn btn-xs btn-warning icon-print2" style="float: right;margin-bottom: 10px"
                                    onclick="print_rpt('PrintSecurity')">&nbsp;<?= __('Print') ?>
                            </button>
                        </div>
                        <div id="PrintSecurity" class="" style="margin-bottom: 40px">
                            <div class="col-sm-12">
                                <h3 class="text-center"><?= __('চালান ফরম') ?></h3>

                                <div class="col-sm-8">
                                    <h4 class=" text-right"><?= __('টি,আর ফরম নং ৬(এস,আর ৩৭ দ্রষ্টব্য)') ?></h4>
                                </div>
                                <div class="col-sm-4">
                                    <table class=" table table-bordered photocopy">
                                        <tr>
                                            <td><?= __('১ম(মূল)কপি') ?></td>
                                            <td><?= __('২য় কপি') ?></td>
                                            <td><?= __('৩য় কপি') ?></td>
                                        </tr>
                                    </table>
                                </div>


                                <p class="text-center"><?= __('চালান নং................................................................. তারিখ............................................................') ?></p>

                                <p class="text-center"><?= __('বাংলাদেশ ব্যাংক/সোনালী ব্যাংকের..............................................................জেলার...........................................................................শাখায় টাকা জমা দেওয়ার চালান') ?></p>
                                <table class="table top-table">
                                    <tr>
                                        <td><?= __('কোড নং') ?></td>
                                        <td colspan="3">
                                            <table class="text-center">
                                                <tr>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <style>
                                    .table.top-table {
                                        border-bottom: 0px;
                                    }

                                    .table.top-table th, .table.top-table td {
                                        border: 0px;
                                    }

                                    .fixed-table-container {
                                        border: 0px !important;
                                    }

                                    .border {
                                        border: 1px solid #2C3A42 !important;
                                        width: 40px;
                                        height: 40px
                                    }

                                    .para {
                                        line-height: 20px
                                    }
                                </style>
                            </div>
                            <div class="col-sm-12">
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="4"><?= __('জমা প্রদানকারী কর্তৃক পূরণ করিতে হইবে') ?></td>
                                        <td colspan="2"><?= __('টাকার অংক') ?></td>
                                        <td rowspan="2"><?= __('বিভাগের নাম এবং চালানের পৃষ্ঠাংকনকারী কর্মকর্তার নাম, পদবী ও দপ্তর।*') ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('যাহার মারফত প্রদত্ত হইল তাহার নাম ও ঠিকানা।') ?></td>
                                        <td><?= __('যে ব্যক্তির/ প্রতিষ্ঠানের পক্ষ হইতে টাকা প্রদত্ত হইল তাহার নাম, পদবী ও ঠিকানা। ') ?></td>
                                        <td><?= __('কি বাবদ জমা দেওয়া হইল তাহার বিবরণ।') ?></td>
                                        <td><?= __('মুদ্রা ও নোটের বিব্রন/ড্রাফট, পে-অর্ডার ও চেকের বিবরণ।') ?></td>
                                        <td><?= __('টাকা') ?></td>
                                        <td><?= __('পয়সা') ?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><?php echo  $purtoBill['contractor'] ?></td>
                                        <td><?= $this->Number->format($purtoBill['id']) ?>
                                            কাজের <?= $purtoBill['bill_type']?$purtoBill['bill_type']:'' ?> বিলের অবশিষ্ঠ অংশ সহ জামানত কর্তন</td>
                                        <td>বুক ট্রান্সফার</td>
                                        <td><?= $this->Number->format($purtoBill['security']) ?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><?= __('মোট টাকা') ?></td>
                                        <td><?= $this->Number->format($purtoBill['security']) ?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><?= __('টাকা (কথায়) ') ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><?= __('টাকা পাওয়া গেল ') ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"
                                            style="border-right: none"><?= __('তারিখ.............................................') ?></td>
                                        <td colspan="3" class="text-center" style="border-top: none; border-left: none">
                                            <span><?= __('ম্যানেজার') ?></span><br>
                                            <span><?= __('বাংলাদেশ ব্যাংক/ সোনালী ব্যাংক') ?></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-12" style="margin-top: 15px">
                                <p style="float: left">নোটঃ&nbsp;
                                <ul style="list-style: none">
                                    <li>১। সংশ্লিষ্ট দপ্তরের সহিত যোগাযোগ করিয়া সঠিক কোড নম্বর জানিয়া লইবেন।</li>
                                    <li>২। *যে সকল ক্ষেত্রে কর্মকর্তা কর্তৃক পৃষ্ঠাংকন প্রয়োজন, সে সকল ক্ষেত্রে প্রযোজ্য
                                        হইবে।
                                    </li>
                                </ul>
                                </p>
                                <p>বাঃসঃমুঃ-২০১১/১২-১০০১১ কম(সি)-২,০০,০০,০০০ কপি,(মুদ্রণাদেশ নং-৭২/১১-১২)২০১৩। </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($purtoBill['vat'])) { ?>
                    <div id="vat" class="tab-pane fade">
                        <div class="col-sm-12">
                            <button class="btn btn-xs btn-warning icon-print2" style="float: right;margin-bottom: 10px"
                                    onclick="print_rpt('PrintVat')">&nbsp;<?= __('Print') ?>
                            </button>
                        </div>
                        <div id="PrintVat" class="" style="margin-bottom: 40px">
                            <div class="col-sm-12">
                                <h3 class="text-center"><?= __('চালান ফরম') ?></h3>

                                <div class="col-sm-8">
                                    <h4 class=" text-right"><?= __('টি,আর ফরম নং ৬(এস,আর ৩৭ দ্রষ্টব্য)') ?></h4>
                                </div>
                                <div class="col-sm-4">
                                    <table class=" table table-bordered photocopy">
                                        <tr>
                                            <td><?= __('১ম(মূল)কপি') ?></td>
                                            <td><?= __('২য় কপি') ?></td>
                                            <td><?= __('৩য় কপি') ?></td>
                                        </tr>
                                    </table>
                                </div>


                                <p class="text-center"><?= __('চালান নং................................................................. তারিখ............................................................') ?></p>

                                <p class="text-center"><?= __('বাংলাদেশ ব্যাংক/সোনালী ব্যাংকের..............................................................জেলার...........................................................................শাখায় টাকা জমা দেওয়ার চালান') ?></p>
                                <table class="table top-table">
                                    <tr>
                                        <td><?= __('কোড নং') ?></td>
                                        <td colspan="3">
                                            <table class="text-center">
                                                <tr>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <style>
                                    .table.top-table {
                                        border-bottom: 0px;
                                    }

                                    .table.top-table th, .table.top-table td {
                                        border: 0px;
                                    }

                                    .fixed-table-container {
                                        border: 0px !important;
                                    }

                                    .border {
                                        border: 1px solid #2C3A42 !important;
                                        width: 40px;
                                        height: 40px
                                    }
                                    .para {
                                        line-height: 20px
                                    }
                                    body{
                                        font-family: 'SutonnyOMJ';

                                    }
                                    .tablesorter {
                                        font-family: 'SutonnyOMJ';;
                                    }

                                    table tr thead th {

                                        font-family: 'SutonnyOMJ';
                                    }

                                    table tr td {
                                        font-family: 'SutonnyOMJ';
                                    }
                                </style>
                            </div>
                            <div class="col-sm-12">
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="4"><?= __('জমা প্রদানকারী কর্তৃক পূরণ করিতে হইবে') ?></td>
                                        <td colspan="2"><?= __('টাকার অংক') ?></td>
                                        <td rowspan="2"><?= __('বিভাগের নাম এবং চালানের পৃষ্ঠাংকনকারী কর্মকর্তার নাম, পদবী ও দপ্তর।*') ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('যাহার মারফত প্রদত্ত হইল তাহার নাম ও ঠিকানা।') ?></td>
                                        <td><?= __('যে ব্যক্তির/ প্রতিষ্ঠানের পক্ষ হইতে টাকা প্রদত্ত হইল তাহার নাম, পদবী ও ঠিকানা। ') ?></td>
                                        <td><?= __('কি বাবদ জমা দেওয়া হইল তাহার বিবরণ।') ?></td>
                                        <td><?= __('মুদ্রা ও নোটের বিব্রন/ড্রাফট, পে-অর্ডার ও চেকের বিবরণ।') ?></td>
                                        <td><?= __('টাকা') ?></td>
                                        <td><?= __('পয়সা') ?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;<?= $purtoBill['contractor'] ?></td>
                                        <td><?= $purtoBill['scheme_name'] ?> <?= $purtoBill['bill_type']?$purtoBill['bill_type']:'' ?> বিলের ভ্যাট কর্তন</td>
                                        <td>&nbsp;</td>
                                        <td><?= $this->Number->format($purtoBill['vat']) ?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><?= __('মোট টাকা') ?></td>
                                        <td><?= $this->Number->format($purtoBill['vat']) ?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><?= __('টাকা (কথায়) ') ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><?= __('টাকা পাওয়া গেল ') ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"
                                            style="border-right: none"><?= __('তারিখ.............................................') ?></td>
                                        <td colspan="3" class="text-center" style="border-top: none; border-left: none">
                                            <span><?= __('ম্যানেজার') ?></span><br>
                                            <span><?= __('বাংলাদেশ ব্যাংক/ সোনালী ব্যাংক') ?></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-12" style="margin-top: 15px">
                                <p style="float: left">নোটঃ&nbsp;
                                <ul style="list-style: none">
                                    <li>১। সংশ্লিষ্ট দপ্তরের সহিত যোগাযোগ করিয়া সঠিক কোড নম্বর জানিয়া লইবেন।</li>
                                    <li>২। *যে সকল ক্ষেত্রে কর্মকর্তা কর্তৃক পৃষ্ঠাংকন প্রয়োজন, সে সকল ক্ষেত্রে প্রযোজ্য
                                        হইবে।
                                    </li>
                                </ul>
                                </p>
                                <p>বাঃসঃমুঃ-২০১১/১২-১০০১১ কম(সি)-২,০০,০০,০০০ কপি,(মুদ্রণাদেশ নং-৭২/১১-১২)২০১৩। </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($purtoBill['income_tex'])) { ?>
                    <div id="income_taxes" class="tab-pane fade">
                        <div class="col-sm-12">
                            <button class="btn btn-xs btn-warning icon-print2" style="float: right;margin-bottom: 10px"
                                    onclick="print_rpt('PrintIncomeTax')">&nbsp;<?= __('Print') ?>
                            </button>
                        </div>
                        <div id="PrintIncomeTax" class="" style="margin-bottom: 40px">
                            <div class="col-sm-12">
                                <h3 class="text-center"><?= __('চালান ফরম') ?></h3>

                                <div class="col-sm-8">
                                    <h4 class=" text-right"><?= __('টি,আর ফরম নং ৬(এস,আর ৩৭ দ্রষ্টব্য)') ?></h4>
                                </div>
                                <div class="col-sm-4">
                                    <table class=" table table-bordered photocopy">
                                        <tr>
                                            <td><?= __('১ম(মূল)কপি') ?></td>
                                            <td><?= __('২য় কপি') ?></td>
                                            <td><?= __('৩য় কপি') ?></td>
                                        </tr>
                                    </table>
                                </div>


                                <p class="text-center"><?= __('চালান নং................................................................. তারিখ............................................................') ?></p>

                                <p class="text-center"><?= __('বাংলাদেশ ব্যাংক/সোনালী ব্যাংকের..............................................................জেলার...........................................................................শাখায় টাকা জমা দেওয়ার চালান') ?></p>
                                <table class="table top-table">
                                    <tr>
                                        <td><?= __('কোড নং') ?></td>
                                        <td colspan="3">
                                            <table class="text-center">
                                                <tr>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <style>
                                    .table.top-table {
                                        border-bottom: 0px;
                                    }

                                    .table.top-table th, .table.top-table td {
                                        border: 0px;
                                    }

                                    .fixed-table-container {
                                        border: 0px !important;
                                    }

                                    .border {
                                        border: 1px solid #2C3A42 !important;
                                        width: 40px;
                                        height: 40px
                                    }

                                    .para {
                                        line-height: 20px
                                    }
                                    body{
                                        font-family: 'SutonnyOMJ';

                                    }
                                    .tablesorter {
                                        font-family: 'SutonnyOMJ';;
                                    }

                                    table tr thead th {

                                        font-family: 'SutonnyOMJ';
                                    }

                                    table tr td {
                                        font-family: 'SutonnyOMJ';
                                    }
                                </style>
                            </div>
                            <div class="col-sm-12">
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="4"><?= __('জমা প্রদানকারী কর্তৃক পূরণ করিতে হইবে') ?></td>
                                        <td colspan="2"><?= __('টাকার অংক') ?></td>
                                        <td rowspan="2"><?= __('বিভাগের নাম এবং চালানের পৃষ্ঠাংকনকারী কর্মকর্তার নাম, পদবী ও দপ্তর।*') ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('যাহার মারফত প্রদত্ত হইল তাহার নাম ও ঠিকানা।') ?></td>
                                        <td><?= __('যে ব্যক্তির/ প্রতিষ্ঠানের পক্ষ হইতে টাকা প্রদত্ত হইল তাহার নাম, পদবী ও ঠিকানা। ') ?></td>
                                        <td><?= __('কি বাবদ জমা দেওয়া হইল তাহার বিবরণ।') ?></td>
                                        <td><?= __('মুদ্রা ও নোটের বিব্রন/ড্রাফট, পে-অর্ডার ও চেকের বিবরণ।') ?></td>
                                        <td><?= __('টাকা') ?></td>
                                        <td><?= __('পয়সা') ?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;<?= $purtoBill['contractor']?></td>
                                        <td><?= $purtoBill['scheme_name'] ?> <?= $purtoBill['bill_type']?$purtoBill['bill_type']:'' ?> বিলের আয়কর কর্তন</td>
                                        <td>&nbsp;</td>
                                        <td><?= $this->Number->format($purtoBill['income_tex']) ?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><?= __('মোট টাকা') ?></td>
                                        <td><?= $this->Number->format($purtoBill['income_tex']) ?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><?= __('টাকা (কথায়) ') ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><?= __('টাকা পাওয়া গেল ') ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"
                                            style="border-right: none"><?= __('তারিখ.............................................') ?></td>
                                        <td colspan="3" class="text-center" style="border-top: none; border-left: none">
                                            <span><?= __('ম্যানেজার') ?></span><br>
                                            <span><?= __('বাংলাদেশ ব্যাংক/ সোনালী ব্যাংক') ?></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-12" style="margin-top: 15px">
                                <p style="float: left">নোটঃ&nbsp;
                                <ul style="list-style: none">
                                    <li>১। সংশ্লিষ্ট দপ্তরের সহিত যোগাযোগ করিয়া সঠিক কোড নম্বর জানিয়া লইবেন।</li>
                                    <li>২। *যে সকল ক্ষেত্রে কর্মকর্তা কর্তৃক পৃষ্ঠাংকন প্রয়োজন, সে সকল ক্ষেত্রে প্রযোজ্য
                                        হইবে।
                                    </li>
                                </ul>
                                </p>
                                <p>বাঃসঃমুঃ-২০১১/১২-১০০১১ কম(সি)-২,০০,০০,০০০ কপি,(মুদ্রণাদেশ নং-৭২/১১-১২)২০১৩। </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($purtoBill['hire_charge'])) { ?>
                    <div id="roller_charge" class="tab-pane fade">
                        <div class="col-sm-12">
                            <button class="btn btn-xs btn-warning icon-print2" style="float: right;margin-bottom: 10px"
                                    onclick="print_rpt('PrintRollerCharge')">&nbsp;<?= __('Print') ?>
                            </button>
                        </div>
                        <div id="PrintRollerCharge" class="" style="margin-bottom: 40px">
                            <div class="col-sm-12">
                                <h3 class="text-center"><?= __('চালান ফরম') ?></h3>

                                <div class="col-sm-8">
                                    <h4 class=" text-right"><?= __('টি,আর ফরম নং ৬(এস,আর ৩৭ দ্রষ্টব্য)') ?></h4>
                                </div>
                                <div class="col-sm-4">
                                    <table class=" table table-bordered photocopy">
                                        <tr>
                                            <td><?= __('১ম(মূল)কপি') ?></td>
                                            <td><?= __('২য় কপি') ?></td>
                                            <td><?= __('৩য় কপি') ?></td>
                                        </tr>
                                    </table>
                                </div>


                                <p class="text-center"><?= __('চালান নং................................................................. তারিখ............................................................') ?></p>

                                <p class="text-center"><?= __('বাংলাদেশ ব্যাংক/সোনালী ব্যাংকের..............................................................জেলার...........................................................................শাখায় টাকা জমা দেওয়ার চালান') ?></p>
                                <table class="table top-table">
                                    <tr>
                                        <td><?= __('কোড নং') ?></td>
                                        <td colspan="3">
                                            <table class="text-center">
                                                <tr>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <style>
                                    .table.top-table {
                                        border-bottom: 0px;
                                    }

                                    .table.top-table th, .table.top-table td {
                                        border: 0px;
                                    }

                                    .fixed-table-container {
                                        border: 0px !important;
                                    }

                                    .border {
                                        border: 1px solid #2C3A42 !important;
                                        width: 40px;
                                        height: 40px
                                    }

                                    .para {
                                        line-height: 20px
                                    }
                                    body{
                                        font-family: 'SutonnyOMJ';

                                    }
                                    .tablesorter {
                                        font-family: 'SutonnyOMJ';;
                                    }

                                    table tr thead th {

                                        font-family: 'SutonnyOMJ';
                                    }

                                    table tr td {
                                        font-family: 'SutonnyOMJ';
                                    }
                                </style>
                            </div>
                            <div class="col-sm-12">
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="4"><?= __('জমা প্রদানকারী কর্তৃক পূরণ করিতে হইবে') ?></td>
                                        <td colspan="2"><?= __('টাকার অংক') ?></td>
                                        <td rowspan="2"><?= __('বিভাগের নাম এবং চালানের পৃষ্ঠাংকনকারী কর্মকর্তার নাম, পদবী ও দপ্তর।*') ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('যাহার মারফত প্রদত্ত হইল তাহার নাম ও ঠিকানা।') ?></td>
                                        <td><?= __('যে ব্যক্তির/ প্রতিষ্ঠানের পক্ষ হইতে টাকা প্রদত্ত হইল তাহার নাম, পদবী ও ঠিকানা। ') ?></td>
                                        <td><?= __('কি বাবদ জমা দেওয়া হইল তাহার বিবরণ।') ?></td>
                                        <td><?= __('মুদ্রা ও নোটের বিব্রন/ড্রাফট, পে-অর্ডার ও চেকের বিবরণ।') ?></td>
                                        <td><?= __('টাকা') ?></td>
                                        <td><?= __('পয়সা') ?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;<?= $purtoBill['contractor']?></td>
                                        <td><?= $purtoBill['scheme_name'] ?> <?= $purtoBill['bill_type']?$purtoBill['bill_type']:'' ?> বিলের রোলার ভাড়া  কর্তন</td>
                                        <td>&nbsp;</td>
                                        <td><?= $this->Number->format($purtoBill['hire_charge']) ?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><?= __('মোট টাকা') ?></td>
                                        <td><?= $this->Number->format($purtoBill['hire_charge']) ?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><?= __('টাকা (কথায়) ') ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><?= __('টাকা পাওয়া গেল ') ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"
                                            style="border-right: none"><?= __('তারিখ.............................................') ?></td>
                                        <td colspan="3" class="text-center" style="border-top: none; border-left: none">
                                            <span><?= __('ম্যানেজার') ?></span><br>
                                            <span><?= __('বাংলাদেশ ব্যাংক/ সোনালী ব্যাংক') ?></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-12" style="margin-top: 15px">
                                <p style="float: left">নোটঃ&nbsp;
                                <ul style="list-style: none">
                                    <li>১। সংশ্লিষ্ট দপ্তরের সহিত যোগাযোগ করিয়া সঠিক কোড নম্বর জানিয়া লইবেন।</li>
                                    <li>২। *যে সকল ক্ষেত্রে কর্মকর্তা কর্তৃক পৃষ্ঠাংকন প্রয়োজন, সে সকল ক্ষেত্রে প্রযোজ্য
                                        হইবে।
                                    </li>
                                </ul>
                                </p>
                                <p>বাঃসঃমুঃ-২০১১/১২-১০০১১ কম(সি)-২,০০,০০,০০০ কপি,(মুদ্রণাদেশ নং-৭২/১১-১২)২০১৩। </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($purtoBill['lab_fee'])) { ?>
                    <div id="lab_fee" class="tab-pane fade">
                        <div class="col-sm-12">
                            <button class="btn btn-xs btn-warning icon-print2" style="float: right;margin-bottom: 10px"
                                    onclick="print_rpt('PrintLabFee')">&nbsp;<?= __('Print') ?>
                            </button>
                        </div>
                        <div id="PrintLabFee" class="" style="margin-bottom: 40px">
                            <div class="col-sm-12">
                                <h3 class="text-center"><?= __('চালান ফরম') ?></h3>

                                <div class="col-sm-8">
                                    <h4 class=" text-right"><?= __('টি,আর ফরম নং ৬(এস,আর ৩৭ দ্রষ্টব্য)') ?></h4>
                                </div>
                                <div class="col-sm-4">
                                    <table class=" table table-bordered photocopy">
                                        <tr>
                                            <td><?= __('১ম(মূল)কপি') ?></td>
                                            <td><?= __('২য় কপি') ?></td>
                                            <td><?= __('৩য় কপি') ?></td>
                                        </tr>
                                    </table>
                                </div>


                                <p class="text-center"><?= __('চালান নং................................................................. তারিখ............................................................') ?></p>

                                <p class="text-center"><?= __('বাংলাদেশ ব্যাংক/সোনালী ব্যাংকের..............................................................জেলার...........................................................................শাখায় টাকা জমা দেওয়ার চালান') ?></p>
                                <table class="table top-table">
                                    <tr>
                                        <td><?= __('কোড নং') ?></td>
                                        <td colspan="3">
                                            <table class="text-center">
                                                <tr>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <style>
                                    .table.top-table {
                                        border-bottom: 0px;
                                    }

                                    .table.top-table th, .table.top-table td {
                                        border: 0px;
                                    }

                                    .fixed-table-container {
                                        border: 0px !important;
                                    }

                                    .border {
                                        border: 1px solid #2C3A42 !important;
                                        width: 40px;
                                        height: 40px
                                    }

                                    .para {
                                        line-height: 20px
                                    }
                                    body{
                                        font-family: 'SutonnyOMJ';

                                    }
                                    .tablesorter {
                                        font-family: 'SutonnyOMJ';;
                                    }

                                    table tr thead th {

                                        font-family: 'SutonnyOMJ';
                                    }

                                    table tr td {
                                        font-family: 'SutonnyOMJ';
                                    }
                                </style>
                            </div>
                            <div class="col-sm-12">
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="4"><?= __('জমা প্রদানকারী কর্তৃক পূরণ করিতে হইবে') ?></td>
                                        <td colspan="2"><?= __('টাকার অংক') ?></td>
                                        <td rowspan="2"><?= __('বিভাগের নাম এবং চালানের পৃষ্ঠাংকনকারী কর্মকর্তার নাম, পদবী ও দপ্তর।*') ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('যাহার মারফত প্রদত্ত হইল তাহার নাম ও ঠিকানা।') ?></td>
                                        <td><?= __('যে ব্যক্তির/ প্রতিষ্ঠানের পক্ষ হইতে টাকা প্রদত্ত হইল তাহার নাম, পদবী ও ঠিকানা। ') ?></td>
                                        <td><?= __('কি বাবদ জমা দেওয়া হইল তাহার বিবরণ।') ?></td>
                                        <td><?= __('মুদ্রা ও নোটের বিব্রন/ড্রাফট, পে-অর্ডার ও চেকের বিবরণ।') ?></td>
                                        <td><?= __('টাকা') ?></td>
                                        <td><?= __('পয়সা') ?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;<?= $purtoBill['contractor']?></td>
                                        <td><?= $purtoBill['scheme_name'] ?> <?= $purtoBill['bill_type']?$purtoBill['bill_type']:'' ?> বিলের ল্যাব  কর্তন</td>
                                        <td>&nbsp;</td>
                                        <td><?= $this->Number->format($purtoBill['lab_fee']) ?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><?= __('মোট টাকা') ?></td>
                                        <td><?= $this->Number->format($purtoBill['lab_fee']) ?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><?= __('টাকা (কথায়) ') ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><?= __('টাকা পাওয়া গেল ') ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"
                                            style="border-right: none"><?= __('তারিখ.............................................') ?></td>
                                        <td colspan="3" class="text-center" style="border-top: none; border-left: none">
                                            <span><?= __('ম্যানেজার') ?></span><br>
                                            <span><?= __('বাংলাদেশ ব্যাংক/ সোনালী ব্যাংক') ?></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-12" style="margin-top: 15px">
                                <p style="float: left">নোটঃ&nbsp;
                                <ul style="list-style: none">
                                    <li>১। সংশ্লিষ্ট দপ্তরের সহিত যোগাযোগ করিয়া সঠিক কোড নম্বর জানিয়া লইবেন।</li>
                                    <li>২। *যে সকল ক্ষেত্রে কর্মকর্তা কর্তৃক পৃষ্ঠাংকন প্রয়োজন, সে সকল ক্ষেত্রে প্রযোজ্য
                                        হইবে।
                                    </li>
                                </ul>
                                </p>
                                <p>বাঃসঃমুঃ-২০১১/১২-১০০১১ কম(সি)-২,০০,০০,০০০ কপি,(মুদ্রণাদেশ নং-৭২/১১-১২)২০১৩। </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($purtoBill['fine'])) { ?>
                    <div id="fine" class="tab-pane fade">
                        <div class="col-sm-12">
                            <button class="btn btn-xs btn-warning icon-print2" style="float: right;margin-bottom: 10px"
                                    onclick="print_rpt('PrintFine')">&nbsp;<?= __('Print') ?>
                            </button>
                        </div>
                        <div id="PrintFine" class="" style="margin-bottom: 40px">
                            <div class="col-sm-12">
                                <h3 class="text-center"><?= __('চালান ফরম') ?></h3>

                                <div class="col-sm-8">
                                    <h4 class=" text-right"><?= __('টি,আর ফরম নং ৬(এস,আর ৩৭ দ্রষ্টব্য)') ?></h4>
                                </div>
                                <div class="col-sm-4">
                                    <table class=" table table-bordered photocopy">
                                        <tr>
                                            <td><?= __('১ম(মূল)কপি') ?></td>
                                            <td><?= __('২য় কপি') ?></td>
                                            <td><?= __('৩য় কপি') ?></td>
                                        </tr>
                                    </table>
                                </div>


                                <p class="text-center"><?= __('চালান নং................................................................. তারিখ............................................................') ?></p>

                                <p class="text-center"><?= __('বাংলাদেশ ব্যাংক/সোনালী ব্যাংকের..............................................................জেলার...........................................................................শাখায় টাকা জমা দেওয়ার চালান') ?></p>
                                <table class="table top-table">
                                    <tr>
                                        <td><?= __('কোড নং') ?></td>
                                        <td colspan="3">
                                            <table class="text-center">
                                                <tr>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <style>
                                    .table.top-table {
                                        border-bottom: 0px;
                                    }

                                    .table.top-table th, .table.top-table td {
                                        border: 0px;
                                    }

                                    .fixed-table-container {
                                        border: 0px !important;
                                    }

                                    .border {
                                        border: 1px solid #2C3A42 !important;
                                        width: 40px;
                                        height: 40px
                                    }

                                    .para {
                                        line-height: 20px
                                    }
                                    body{
                                        font-family: 'SutonnyOMJ';

                                    }
                                    .tablesorter {
                                        font-family: 'SutonnyOMJ';;
                                    }

                                    table tr thead th {

                                        font-family: 'SutonnyOMJ';
                                    }

                                    table tr td {
                                        font-family: 'SutonnyOMJ';
                                    }
                                </style>
                            </div>
                            <div class="col-sm-12">
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="4"><?= __('জমা প্রদানকারী কর্তৃক পূরণ করিতে হইবে') ?></td>
                                        <td colspan="2"><?= __('টাকার অংক') ?></td>
                                        <td rowspan="2"><?= __('বিভাগের নাম এবং চালানের পৃষ্ঠাংকনকারী কর্মকর্তার নাম, পদবী ও দপ্তর।*') ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('যাহার মারফত প্রদত্ত হইল তাহার নাম ও ঠিকানা।') ?></td>
                                        <td><?= __('যে ব্যক্তির/ প্রতিষ্ঠানের পক্ষ হইতে টাকা প্রদত্ত হইল তাহার নাম, পদবী ও ঠিকানা। ') ?></td>
                                        <td><?= __('কি বাবদ জমা দেওয়া হইল তাহার বিবরণ।') ?></td>
                                        <td><?= __('মুদ্রা ও নোটের বিব্রন/ড্রাফট, পে-অর্ডার ও চেকের বিবরণ।') ?></td>
                                        <td><?= __('টাকা') ?></td>
                                        <td><?= __('পয়সা') ?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;<?= $purtoBill['contractor']?></td>
                                        <td><?= $purtoBill['scheme_name'] ?> <?= $purtoBill['bill_type']?$purtoBill['bill_type']:'' ?> বিলের জরিমানা  কর্তন</td>
                                        <td>&nbsp;</td>
                                        <td><?= $this->Number->format($purtoBill['fine']) ?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><?= __('মোট টাকা') ?></td>
                                        <td><?= $this->Number->format($purtoBill['fine']) ?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><?= __('টাকা (কথায়) ') ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><?= __('টাকা পাওয়া গেল ') ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"
                                            style="border-right: none"><?= __('তারিখ.............................................') ?></td>
                                        <td colspan="3" class="text-center" style="border-top: none; border-left: none">
                                            <span><?= __('ম্যানেজার') ?></span><br>
                                            <span><?= __('বাংলাদেশ ব্যাংক/ সোনালী ব্যাংক') ?></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-12" style="margin-top: 15px">
                                <p style="float: left">নোটঃ&nbsp;
                                <ul style="list-style: none">
                                    <li>১। সংশ্লিষ্ট দপ্তরের সহিত যোগাযোগ করিয়া সঠিক কোড নম্বর জানিয়া লইবেন।</li>
                                    <li>২। *যে সকল ক্ষেত্রে কর্মকর্তা কর্তৃক পৃষ্ঠাংকন প্রয়োজন, সে সকল ক্ষেত্রে প্রযোজ্য
                                        হইবে।
                                    </li>
                                </ul>
                                </p>
                                <p>বাঃসঃমুঃ-২০১১/১২-১০০১১ কম(সি)-২,০০,০০,০০০ কপি,(মুদ্রণাদেশ নং-৭২/১১-১২)২০১৩। </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($purtoBill['cost_of_material'])) { ?>
                    <div id="cost_of_material" class="tab-pane fade">
                        <div class="col-sm-12">
                            <button class="btn btn-xs btn-warning icon-print2" style="float: right;margin-bottom: 10px"
                                    onclick="print_rpt('PrintFine')">&nbsp;<?= __('Print') ?>
                            </button>
                        </div>
                        <div id="PrintFine" class="" style="margin-bottom: 40px">
                            <div class="col-sm-12">
                                <h3 class="text-center"><?= __('চালান ফরম') ?></h3>

                                <div class="col-sm-8">
                                    <h4 class=" text-right"><?= __('টি,আর ফরম নং ৬(এস,আর ৩৭ দ্রষ্টব্য)') ?></h4>
                                </div>
                                <div class="col-sm-4">
                                    <table class=" table table-bordered photocopy">
                                        <tr>
                                            <td><?= __('১ম(মূল)কপি') ?></td>
                                            <td><?= __('২য় কপি') ?></td>
                                            <td><?= __('৩য় কপি') ?></td>
                                        </tr>
                                    </table>
                                </div>


                                <p class="text-center"><?= __('চালান নং................................................................. তারিখ............................................................') ?></p>

                                <p class="text-center"><?= __('বাংলাদেশ ব্যাংক/সোনালী ব্যাংকের..............................................................জেলার...........................................................................শাখায় টাকা জমা দেওয়ার চালান') ?></p>
                                <table class="table top-table">
                                    <tr>
                                        <td><?= __('কোড নং') ?></td>
                                        <td colspan="3">
                                            <table class="text-center">
                                                <tr>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <style>
                                    .table.top-table {
                                        border-bottom: 0px;
                                    }

                                    .table.top-table th, .table.top-table td {
                                        border: 0px;
                                    }

                                    .fixed-table-container {
                                        border: 0px !important;
                                    }

                                    .border {
                                        border: 1px solid #2C3A42 !important;
                                        width: 40px;
                                        height: 40px
                                    }

                                    .para {
                                        line-height: 20px
                                    }
                                    body{
                                        font-family: 'SutonnyOMJ';

                                    }
                                    .tablesorter {
                                        font-family: 'SutonnyOMJ';;
                                    }

                                    table tr thead th {

                                        font-family: 'SutonnyOMJ';
                                    }

                                    table tr td {
                                        font-family: 'SutonnyOMJ';
                                    }
                                </style>
                            </div>
                            <div class="col-sm-12">
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="4"><?= __('জমা প্রদানকারী কর্তৃক পূরণ করিতে হইবে') ?></td>
                                        <td colspan="2"><?= __('টাকার অংক') ?></td>
                                        <td rowspan="2"><?= __('বিভাগের নাম এবং চালানের পৃষ্ঠাংকনকারী কর্মকর্তার নাম, পদবী ও দপ্তর।*') ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('যাহার মারফত প্রদত্ত হইল তাহার নাম ও ঠিকানা।') ?></td>
                                        <td><?= __('যে ব্যক্তির/ প্রতিষ্ঠানের পক্ষ হইতে টাকা প্রদত্ত হইল তাহার নাম, পদবী ও ঠিকানা। ') ?></td>
                                        <td><?= __('কি বাবদ জমা দেওয়া হইল তাহার বিবরণ।') ?></td>
                                        <td><?= __('মুদ্রা ও নোটের বিব্রন/ড্রাফট, পে-অর্ডার ও চেকের বিবরণ।') ?></td>
                                        <td><?= __('টাকা') ?></td>
                                        <td><?= __('পয়সা') ?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;<?= $purtoBill['contractor']?></td>
                                        <td><?= $purtoBill['name_bn'] ?> <?= $purtoBill['bill_type']?$purtoBill['bill_type']:'' ?> বিলের জরিমানা  কর্তন</td>
                                        <td>&nbsp;</td>
                                        <td><?= $this->Number->format($purtoBill['cost_of_material']) ?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><?= __('মোট টাকা') ?></td>
                                        <td><?= $this->Number->format($purtoBill['cost_of_material']) ?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><?= __('টাকা (কথায়) ') ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><?= __('টাকা পাওয়া গেল ') ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"
                                            style="border-right: none"><?= __('তারিখ.............................................') ?></td>
                                        <td colspan="3" class="text-center" style="border-top: none; border-left: none">
                                            <span><?= __('ম্যানেজার') ?></span><br>
                                            <span><?= __('বাংলাদেশ ব্যাংক/ সোনালী ব্যাংক') ?></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-12" style="margin-top: 15px">
                                <p style="float: left">নোটঃ&nbsp;
                                <ul style="list-style: none">
                                    <li>১। সংশ্লিষ্ট দপ্তরের সহিত যোগাযোগ করিয়া সঠিক কোড নম্বর জানিয়া লইবেন।</li>
                                    <li>২। *যে সকল ক্ষেত্রে কর্মকর্তা কর্তৃক পৃষ্ঠাংকন প্রয়োজন, সে সকল ক্ষেত্রে প্রযোজ্য
                                        হইবে।
                                    </li>
                                </ul>
                                </p>
                                <p>বাঃসঃমুঃ-২০১১/১২-১০০১১ কম(সি)-২,০০,০০,০০০ কপি,(মুদ্রণাদেশ নং-৭২/১১-১২)২০১৩। </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($purtoBill['etc_fee'])) { ?>
                    <div id="etc_fee" class="tab-pane fade">
                        <div class="col-sm-12">
                            <button class="btn btn-xs btn-warning icon-print2" style="float: right;margin-bottom: 10px"
                                    onclick="print_rpt('PrintFine')">&nbsp;<?= __('Print') ?>
                            </button>
                        </div>
                        <div id="PrintFine" class="" style="margin-bottom: 40px">
                            <div class="col-sm-12">
                                <h3 class="text-center"><?= __('চালান ফরম') ?></h3>

                                <div class="col-sm-8">
                                    <h4 class=" text-right"><?= __('টি,আর ফরম নং ৬(এস,আর ৩৭ দ্রষ্টব্য)') ?></h4>
                                </div>
                                <div class="col-sm-4">
                                    <table class=" table table-bordered photocopy">
                                        <tr>
                                            <td><?= __('১ম(মূল)কপি') ?></td>
                                            <td><?= __('২য় কপি') ?></td>
                                            <td><?= __('৩য় কপি') ?></td>
                                        </tr>
                                    </table>
                                </div>


                                <p class="text-center"><?= __('চালান নং................................................................. তারিখ............................................................') ?></p>

                                <p class="text-center"><?= __('বাংলাদেশ ব্যাংক/সোনালী ব্যাংকের..............................................................জেলার...........................................................................শাখায় টাকা জমা দেওয়ার চালান') ?></p>
                                <table class="table top-table">
                                    <tr>
                                        <td><?= __('কোড নং') ?></td>
                                        <td colspan="3">
                                            <table class="text-center">
                                                <tr>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td>--</td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                    <td class="border"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <style>
                                    .table.top-table {
                                        border-bottom: 0px;
                                    }

                                    .table.top-table th, .table.top-table td {
                                        border: 0px;
                                    }

                                    .fixed-table-container {
                                        border: 0px !important;
                                    }

                                    .border {
                                        border: 1px solid #2C3A42 !important;
                                        width: 40px;
                                        height: 40px
                                    }

                                    .para {
                                        line-height: 20px
                                    }
                                    body{
                                        font-family: 'SutonnyOMJ';

                                    }
                                    .tablesorter {
                                        font-family: 'SutonnyOMJ';;
                                    }

                                    table tr thead th {

                                        font-family: 'SutonnyOMJ';
                                    }

                                    table tr td {
                                        font-family: 'SutonnyOMJ';
                                    }
                                </style>
                            </div>
                            <div class="col-sm-12">
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="4"><?= __('জমা প্রদানকারী কর্তৃক পূরণ করিতে হইবে') ?></td>
                                        <td colspan="2"><?= __('টাকার অংক') ?></td>
                                        <td rowspan="2"><?= __('বিভাগের নাম এবং চালানের পৃষ্ঠাংকনকারী কর্মকর্তার নাম, পদবী ও দপ্তর।*') ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= __('যাহার মারফত প্রদত্ত হইল তাহার নাম ও ঠিকানা।') ?></td>
                                        <td><?= __('যে ব্যক্তির/ প্রতিষ্ঠানের পক্ষ হইতে টাকা প্রদত্ত হইল তাহার নাম, পদবী ও ঠিকানা। ') ?></td>
                                        <td><?= __('কি বাবদ জমা দেওয়া হইল তাহার বিবরণ।') ?></td>
                                        <td><?= __('মুদ্রা ও নোটের বিব্রন/ড্রাফট, পে-অর্ডার ও চেকের বিবরণ।') ?></td>
                                        <td><?= __('টাকা') ?></td>
                                        <td><?= __('পয়সা') ?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;<?= $purtoBill['contractor']?></td>
                                        <td><?= $purtoBill['scheme_name'] ?> <?= $purtoBill['bill_type']?$purtoBill['bill_type']:'' ?> বিলের জরিমানা  কর্তন</td>
                                        <td>&nbsp;</td>
                                        <td><?= $this->Number->format($purtoBill['etc_fee']) ?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><?= __('মোট টাকা') ?></td>
                                        <td><?= $this->Number->format($purtoBill['etc_fee']) ?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><?= __('টাকা (কথায়) ') ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><?= __('টাকা পাওয়া গেল ') ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"
                                            style="border-right: none"><?= __('তারিখ.............................................') ?></td>
                                        <td colspan="3" class="text-center" style="border-top: none; border-left: none">
                                            <span><?= __('ম্যানেজার') ?></span><br>
                                            <span><?= __('বাংলাদেশ ব্যাংক/ সোনালী ব্যাংক') ?></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-12" style="margin-top: 15px">
                                <p style="float: left">নোটঃ&nbsp;
                                <ul style="list-style: none">
                                    <li>১। সংশ্লিষ্ট দপ্তরের সহিত যোগাযোগ করিয়া সঠিক কোড নম্বর জানিয়া লইবেন।</li>
                                    <li>২। *যে সকল ক্ষেত্রে কর্মকর্তা কর্তৃক পৃষ্ঠাংকন প্রয়োজন, সে সকল ক্ষেত্রে প্রযোজ্য
                                        হইবে।
                                    </li>
                                </ul>
                                </p>
                                <p>বাঃসঃমুঃ-২০১১/১২-১০০১১ কম(সি)-২,০০,০০,০০০ কপি,(মুদ্রণাদেশ নং-৭২/১১-১২)২০১৩। </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>

</div>


<script>
    function print_rpt(func) {
        URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=" + func;
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }
</script>