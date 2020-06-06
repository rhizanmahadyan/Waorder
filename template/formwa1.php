<div class="formWaBox open" id="orderViaWa">
    <div class="formWa">
        <div class="heading clear">
            <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" width="30px" height="30px">
                <path d="M0,512l35.31-128C12.359,344.276,0,300.138,0,254.234C0,114.759,114.759,0,255.117,0  S512,114.759,512,254.234S395.476,512,255.117,512c-44.138,0-86.51-14.124-124.469-35.31L0,512z" fill="#EDEDED"/>
                <path d="m137.71 430.79 7.945 4.414c32.662 20.303 70.621 32.662 110.34 32.662 115.64 0 211.86-96.221 211.86-213.63s-96.221-210.1-212.74-210.1-210.98 93.572-210.98 210.1c0 40.607 11.476 80.331 32.662 113.88l5.297 7.945-20.303 74.152 75.916-19.421z" fill="#55CD6C"/>
                <path d="m187.14 135.94-16.772-0.883c-5.297 0-10.593 1.766-14.124 5.297-7.945 7.062-21.186 20.303-24.717 37.959-6.179 26.483 3.531 58.262 26.483 90.041s67.09 82.979 144.77 105.05c24.717 7.062 44.138 2.648 60.028-7.062 12.359-7.945 20.303-20.303 22.952-33.545l2.648-12.359c0.883-3.531-0.883-7.945-4.414-9.71l-55.614-25.6c-3.531-1.766-7.945-0.883-10.593 2.648l-22.069 28.248c-1.766 1.766-4.414 2.648-7.062 1.766-15.007-5.297-65.324-26.483-92.69-79.448-0.883-2.648-0.883-5.297 0.883-7.062l21.186-23.834c1.766-2.648 2.648-6.179 1.766-8.828l-25.6-57.379c-0.884-2.649-3.532-5.297-7.063-5.297" fill="#FEFEFE"/>
            </svg>
            <h3><b>Form</b> Whatsapp Order!</h3>
            <div class="close" onclick="closeOrderWA();">×</div>
        </div>
        <div class="item clear">
            <div class="thumb">
                <img src="<?php if( isset($photos[0]['thumb']) ){ echo $photos[0]['thumb'][0];} ?>"/>
            </div>
            <div class="detailbox">
                <div class="detail">
                    <h3><?php the_title(); ?></h3>
                    <table>
                        <tr>
                            <?php if( $size_data ): ?>
                                <td>Ukuran :</td>
                            <?php endif; ?>
                            <?php if( $color_data ): ?>
                                <td>Warna :</td>
                            <?php endif; ?>
                            <?php if( $custom_variable_label ): ?>
                                <td><?php echo $custom_variable_label; ?> :</td>
                            <?php endif; ?>
                            <td>Quantity :</td>
                        </tr>
                        <tr>
                            <?php if( $size_data ): ?>
                                <td id="product_option_size_view"><?php echo $sizes[0]; ?></td>
                            <?php endif; ?>
                            <?php if( $color_data ): ?>
                                <td id="product_option_color_view"><?php echo $colors[0]; ?></td>
                            <?php endif; ?>
                            <?php if( $custom_variable_label ): ?>
                                <?php if( isset($custom_variable_fields['chooser'][0]) ): ?>
                                    <td id="product_option_custom_view">
                                        <?php echo $custom_variable_fields['chooser'][0]; ?>
                                    </td>
                                <?php endif; ?>
                            <?php endif; ?>
                            <td id="product_option_qty_view">1</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="subtotal">
            <table>
                <tr>
                    <td>
                        Sub Total<br>
                        <span style="font-weight: 400;font-style:italic;font-size:10px;">*Belum termasuk Ongkos kirim</span>
                    </td>
                    <td>
                        <span id="product_sub_total_view" style="font-size:18px;color: #FF5050;font-weight: bold">Rp <?php echo number_format($price,0,',','.'); ?></span>&nbsp;<?php if($price_slik){?><span id="product_sub_total_slik_view" ><del>Rp <?php echo number_format($price_slik,0,',','.'); ?></del></span><?php } ?>
                    </td>
                <tr>
            </table>
        </div>
        <div class="subtotal">
            <table>
                <tr>
                    <td>
                        Ongkir
                    </td>
                    <td>
                        <span id="product_sub_total_view" style="font-size:18px;color: #FF5050;font-weight: bold">Rp <?php echo number_format($price,0,',','.'); ?></span>&nbsp;<?php if($price_slik){?><span id="product_sub_total_slik_view" ><del>Rp <?php echo number_format($price_slik,0,',','.'); ?></del></span><?php } ?>
                    </td>
                <tr>
            </table>
        </div>
        <form class="form" method="post" enctype="multipart/form-data" onsubmit="orderWA(this); return false;" action="<?php echo get_the_permalink(); ?>">
            <table>
                <tr>
                    <td>
                        <div class="input">
                            <svg enable-background="new 0 0 53 53" version="1.1" viewBox="0 0 53 53" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px">
                                <path d="m18.613 41.552-7.907 4.313c-0.464 0.253-0.881 0.564-1.269 0.903 4.61 3.887 10.561 6.232 17.063 6.232 6.454 0 12.367-2.31 16.964-6.144-0.424-0.358-0.884-0.68-1.394-0.934l-8.467-4.233c-1.094-0.547-1.785-1.665-1.785-2.888v-3.322c0.238-0.271 0.51-0.619 0.801-1.03 1.154-1.63 2.027-3.423 2.632-5.304 1.086-0.335 1.886-1.338 1.886-2.53v-3.546c0-0.78-0.347-1.477-0.886-1.965v-5.126s1.053-7.977-9.75-7.977-9.75 7.977-9.75 7.977v5.126c-0.54 0.488-0.886 1.185-0.886 1.965v3.546c0 0.934 0.491 1.756 1.226 2.231 0.886 3.857 3.206 6.633 3.206 6.633v3.24c-1e-3 1.18-0.647 2.267-1.684 2.833z" fill="#E7ECED"/>
                                <path d="m26.953 4e-3c-14.633-0.25-26.699 11.41-26.949 26.043-0.142 8.297 3.556 15.754 9.444 20.713 0.385-0.336 0.798-0.644 1.257-0.894l7.907-4.313c1.037-0.566 1.683-1.653 1.683-2.835v-3.24s-2.321-2.776-3.206-6.633c-0.734-0.475-1.226-1.296-1.226-2.231v-3.546c0-0.78 0.347-1.477 0.886-1.965v-5.126s-1.053-7.977 9.75-7.977 9.75 7.977 9.75 7.977v5.126c0.54 0.488 0.886 1.185 0.886 1.965v3.546c0 1.192-0.8 2.195-1.886 2.53-0.605 1.881-1.478 3.674-2.632 5.304-0.291 0.411-0.563 0.759-0.801 1.03v3.322c0 1.223 0.691 2.342 1.785 2.888l8.467 4.233c0.508 0.254 0.967 0.575 1.39 0.932 5.71-4.762 9.399-11.882 9.536-19.9 0.252-14.633-11.407-26.699-26.041-26.949z" fill="rgba(0,0,0,.2)"/>
                            </svg>
                            <input type="text" name="full_name" placeholder="Nama Lengkap" required oninvalid="this.setCustomValidity('Input Nama Lengkap Anda')" oninput="this.setCustomValidity('')">
                        </div>
                    </td>
                    <td>
                        <div class="input">
                            <svg enable-background="new 0 0 27.442 27.442" version="1.1" viewBox="0 0 27.442 27.442" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px">
                                <path d="m19.494 0h-11.546c-1.105 0-1.997 0.896-1.997 1.999v23.446c0 1.102 0.892 1.997 1.997 1.997h11.546c1.103 0 1.997-0.895 1.997-1.997v-23.446c0-1.103-0.894-1.999-1.997-1.999zm-8.622 1.214h5.7c0.144 0 0.261 0.215 0.261 0.481s-0.117 0.482-0.261 0.482h-5.7c-0.145 0-0.26-0.216-0.26-0.482s0.115-0.481 0.26-0.481zm2.85 24.255c-0.703 0-1.275-0.572-1.275-1.276s0.572-1.274 1.275-1.274c0.701 0 1.273 0.57 1.273 1.274s-0.572 1.276-1.273 1.276zm6.273-4.369h-12.547v-17.727h12.547v17.727z" fill="rgba(0,0,0,.2)"/>
                            </svg>
                            <input type="tel" name="phone" placeholder="Nomor Hp" pattern="[0-9]{9,13}" required oninvalid="this.setCustomValidity('Nomor Hp tidak valid!')" oninput="this.setCustomValidity('')">
                        </div>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>
                        <div class="input">
                            <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px">
                                <path fill="rgba(0,0,0,.2)" d="m256 0c-102.24 0-185.43 83.182-185.43 185.43 0 126.89 165.94 313.17 173 321.04 6.636 7.391 18.222 7.378 24.846 0 7.065-7.868 173-194.15 173-321.04-2e-3 -102.24-83.183-185.43-185.43-185.43zm0 469.73c-55.847-66.338-152.04-197.22-152.04-284.3 0-83.834 68.202-152.04 152.04-152.04s152.04 68.202 152.04 152.04c-1e-3 87.088-96.174 217.94-152.04 284.3z"/>
                                <path fill="rgba(0,0,0,.2)" d="m256 92.134c-51.442 0-93.292 41.851-93.292 93.293s41.851 93.293 93.292 93.293 93.291-41.851 93.291-93.293-41.85-93.293-93.291-93.293zm0 153.19c-33.03 0-59.9-26.871-59.9-59.901s26.871-59.901 59.9-59.901 59.9 26.871 59.9 59.901-26.871 59.901-59.9 59.901z"/>
                            </svg>
                            <input type="tel" name="district" placeholder="Kecamatan" required>
                        </div>
                    </td>
                </tr>
            </table>
            <!--- <table>
                <tr>
                    <td>
                        <div class="input">
                            <svg enable-background="new 0 0 129 129" version="1.1" viewBox="0 0 129 129" xmlns="http://www.w3.org/2000/svg" width="20px" height="25px">
                                <path d="m121.3 34.6c-1.6-1.6-4.2-1.6-5.8 0l-51 51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8 0s-1.6 4.2 0 5.8l53.9 53.9c0.8 0.8 1.8 1.2 2.9 1.2 1 0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z" fill="rgba(0,0,0,.2)"/>
                            </svg>
                            <select required name="payment_type" oninvalid="this.setCustomValidity('Pilih Metode pmbayaran!')" oninput="this.setCustomValidity('')">
                                <option hidden="hidden" selected="selected" value="">Metode Pembayaran</option>
                                <optgroup label="Metode Pembayaran">
                                    <option value="BCA">BCA</option>
                                    <option value="Mandiri">Mandiri</option>
                                    <option value="BNI">BNI</option>
                                    <option value="BRI">BRI</option>
                                </optgroup>
                            </select>
                        </div>
                    </td>
                </tr>
            </table>--->
            <table>
                <tr>
                    <td>
                        <div class="input">
                            <textarea name="address" placeholder="Alamat Lengkap"></textarea>
                        </div>
                    </td>
                </tr>
            </table>
            <!---<table>
                <tr>
                    <td>
                        <div class="input">
                            <svg width="20px" height="20px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <path fill="rgba(0,0,0,.2)" d="m316 260c-5.5195 0-10 4.4805-10 10s4.4805 10 10 10 10-4.4805 10-10-4.4805-10-10-10z"/>
                                <path fill="rgba(0,0,0,.2)" d="m102.17 369.79-100 126c-2.3867 3.0039-2.8398 7.1094-1.1719 10.562 1.668 3.457 5.168 5.6523 9.0039 5.6523h492c3.8359 0 7.3359-2.1953 9.0039-5.6523 1.6719-3.4531 1.2148-7.5586-1.1719-10.562l-100-126c-1.8945-2.3906-4.7812-3.7852-7.832-3.7852h-87.598l74.785-117.3c17.543-26.301 26.812-56.973 26.812-88.703 0-88.223-71.773-160-160-160s-160 71.777-160 160c0 31.73 9.2695 62.398 26.812 88.703l74.785 117.3h-87.598c-3.0508 0-5.9336 1.3945-7.832 3.7852zm-37.336 79.215h60.465l-34.125 43h-60.469zm145.52-63 27.414 43h-71.062l34.129-43zm91.301 0h9.5195l34.125 43h-71.059zm59.52 63 34.125 43h-278.59l34.129-43zm59.66 43-34.129-43h60.469l34.125 43zm10.465-63h-60.465l-34.129-43h60.469zm-291.79-191.31c-15.379-23.023-23.508-49.887-23.508-77.688 0-77.195 62.805-140 140-140s140 62.805 140 140c0 27.801-8.1289 54.664-23.504 77.688-0.042969 0.058594-0.078125 0.11719-0.11719 0.17578-6.5664 10.301-111.32 174.61-116.38 182.54-12.723-19.957-103.42-162.21-116.38-182.54-0.035156-0.058593-0.074219-0.11719-0.11328-0.17578zm35.789 148.31-34.125 43h-60.469l34.129-43z"/>
                                <path fill="rgba(0,0,0,.2)" d="m256 260c54.898 0 100-44.457 100-100 0-55.141-44.859-100-100-100s-100 44.859-100 100c0 55.559 45.117 100 100 100zm0-180c44.113 0 80 35.887 80 80 0 44.523-36.176 80-80 80-43.836 0-80-35.477-80-80 0-44.113 35.887-80 80-80z"/>
                                <path fill="rgba(0,0,0,.2)" d="m298.12 294.12c-4.7266-2.8516-10.875-1.3281-13.727 3.4023l-36.961 61.32c-2.8516 4.7305-1.3281 10.875 3.4023 13.727 4.75 2.8633 10.887 1.3086 13.727-3.4023l36.961-61.32c2.8516-4.7305 1.3281-10.875-3.4023-13.727z"/>
                            </svg>
                            <input type="text" name="address" placeholder="Alamat Lengkap" required oninvalid="this.setCustomValidity('Lengkapi alamat Anda!')" oninput="this.setCustomValidity('')">
                        </div>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>
                        <div class="input">
                            <svg width="20px" height="20px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <path fill="rgba(0,0,0,.2)" d="m316 260c-5.5195 0-10 4.4805-10 10s4.4805 10 10 10 10-4.4805 10-10-4.4805-10-10-10z"/>
                                <path fill="rgba(0,0,0,.2)" d="m102.17 369.79-100 126c-2.3867 3.0039-2.8398 7.1094-1.1719 10.562 1.668 3.457 5.168 5.6523 9.0039 5.6523h492c3.8359 0 7.3359-2.1953 9.0039-5.6523 1.6719-3.4531 1.2148-7.5586-1.1719-10.562l-100-126c-1.8945-2.3906-4.7812-3.7852-7.832-3.7852h-87.598l74.785-117.3c17.543-26.301 26.812-56.973 26.812-88.703 0-88.223-71.773-160-160-160s-160 71.777-160 160c0 31.73 9.2695 62.398 26.812 88.703l74.785 117.3h-87.598c-3.0508 0-5.9336 1.3945-7.832 3.7852zm-37.336 79.215h60.465l-34.125 43h-60.469zm145.52-63 27.414 43h-71.062l34.129-43zm91.301 0h9.5195l34.125 43h-71.059zm59.52 63 34.125 43h-278.59l34.129-43zm59.66 43-34.129-43h60.469l34.125 43zm10.465-63h-60.465l-34.129-43h60.469zm-291.79-191.31c-15.379-23.023-23.508-49.887-23.508-77.688 0-77.195 62.805-140 140-140s140 62.805 140 140c0 27.801-8.1289 54.664-23.504 77.688-0.042969 0.058594-0.078125 0.11719-0.11719 0.17578-6.5664 10.301-111.32 174.61-116.38 182.54-12.723-19.957-103.42-162.21-116.38-182.54-0.035156-0.058593-0.074219-0.11719-0.11328-0.17578zm35.789 148.31-34.125 43h-60.469l34.129-43z"/>
                                <path fill="rgba(0,0,0,.2)" d="m256 260c54.898 0 100-44.457 100-100 0-55.141-44.859-100-100-100s-100 44.859-100 100c0 55.559 45.117 100 100 100zm0-180c44.113 0 80 35.887 80 80 0 44.523-36.176 80-80 80-43.836 0-80-35.477-80-80 0-44.113 35.887-80 80-80z"/>
                                <path fill="rgba(0,0,0,.2)" d="m298.12 294.12c-4.7266-2.8516-10.875-1.3281-13.727 3.4023l-36.961 61.32c-2.8516 4.7305-1.3281 10.875 3.4023 13.727 4.75 2.8633 10.887 1.3086 13.727-3.4023l36.961-61.32c2.8516-4.7305 1.3281-10.875-3.4023-13.727z"/>
                            </svg>
                            <input type="text" name="sub_district" placeholder="Kecamatan" required oninvalid="this.setCustomValidity('Lengkapi nama Kecamatan!')" oninput="this.setCustomValidity('')">
                        </div>
                    </td>
                    <td>
                        <div class="input">
                            <svg width="20px" height="20px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <path fill="rgba(0,0,0,.2)" d="m316 260c-5.5195 0-10 4.4805-10 10s4.4805 10 10 10 10-4.4805 10-10-4.4805-10-10-10z"/>
                                <path fill="rgba(0,0,0,.2)" d="m102.17 369.79-100 126c-2.3867 3.0039-2.8398 7.1094-1.1719 10.562 1.668 3.457 5.168 5.6523 9.0039 5.6523h492c3.8359 0 7.3359-2.1953 9.0039-5.6523 1.6719-3.4531 1.2148-7.5586-1.1719-10.562l-100-126c-1.8945-2.3906-4.7812-3.7852-7.832-3.7852h-87.598l74.785-117.3c17.543-26.301 26.812-56.973 26.812-88.703 0-88.223-71.773-160-160-160s-160 71.777-160 160c0 31.73 9.2695 62.398 26.812 88.703l74.785 117.3h-87.598c-3.0508 0-5.9336 1.3945-7.832 3.7852zm-37.336 79.215h60.465l-34.125 43h-60.469zm145.52-63 27.414 43h-71.062l34.129-43zm91.301 0h9.5195l34.125 43h-71.059zm59.52 63 34.125 43h-278.59l34.129-43zm59.66 43-34.129-43h60.469l34.125 43zm10.465-63h-60.465l-34.129-43h60.469zm-291.79-191.31c-15.379-23.023-23.508-49.887-23.508-77.688 0-77.195 62.805-140 140-140s140 62.805 140 140c0 27.801-8.1289 54.664-23.504 77.688-0.042969 0.058594-0.078125 0.11719-0.11719 0.17578-6.5664 10.301-111.32 174.61-116.38 182.54-12.723-19.957-103.42-162.21-116.38-182.54-0.035156-0.058593-0.074219-0.11719-0.11328-0.17578zm35.789 148.31-34.125 43h-60.469l34.129-43z"/>
                                <path fill="rgba(0,0,0,.2)" d="m256 260c54.898 0 100-44.457 100-100 0-55.141-44.859-100-100-100s-100 44.859-100 100c0 55.559 45.117 100 100 100zm0-180c44.113 0 80 35.887 80 80 0 44.523-36.176 80-80 80-43.836 0-80-35.477-80-80 0-44.113 35.887-80 80-80z"/>
                                <path fill="rgba(0,0,0,.2)" d="m298.12 294.12c-4.7266-2.8516-10.875-1.3281-13.727 3.4023l-36.961 61.32c-2.8516 4.7305-1.3281 10.875 3.4023 13.727 4.75 2.8633 10.887 1.3086 13.727-3.4023l36.961-61.32c2.8516-4.7305 1.3281-10.875-3.4023-13.727z"/>
                            </svg>
                            <input type="text" name="district" placeholder="Kabupaten" required oninvalid="this.setCustomValidity('Lengkapi nama Kabupaten!')" oninput="this.setCustomValidity('')">
                        </div>
                    </td>
                </tr>
            </table>--->
            <?php do_action('waorder_waorder_form_before_submit'); ?>
            <table>
                <tr>
                    <td>
                        <button id="sendWA" class="color-scheme-background" type="submit">
                            <svg enable-background="new 0 0 535.5 535.5" version="1.1" viewBox="0 0 535.5 535.5" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px">
                                <polygon points="0 497.25 535.5 267.75 0 38.25 0 216.75 382.5 267.75 0 318.75" fill="#ffffff"/>
                            </svg>
                            Kirim
                        </button>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="product" value="<?php the_title(); ?>">
            <input type="hidden" name="product_qty" id="product_option_qty" value="1">
            <?php if( $size_data ): ?>
                <input type="hidden" name="product_size" id="product_option_size" value="<?php echo $sizes[0]; ?>">
            <?php endif; ?>
            <?php if( $color_data ): ?>
                <input type="hidden" name="product_color" id="product_option_color" value="<?php echo $colors[0]; ?>">
            <?php endif; ?>
            <?php if( $custom_variable_label ): ?>
                <?php if( isset($custom_variable_fields['chooser'][0]) ): ?>
                    <input type="hidden" name="product_custom" id="product_option_custom" value="<?php echo $custom_variable_fields['chooser'][0]; ?>">
                    <input type="hidden" name="product_custom_label" id="product_option_custom" value="<?php echo $custom_variable_label; ?>">
                <?php endif; ?>
            <?php endif; ?>
            <input type="hidden" name="product_subtotal" id="product_sub_total" value="Rp <?php echo number_format($price,0,',','.'); ?>">
            <input type="hidden" name="destination" value="<?php echo waorder_admin_phone(); ?>">
            <input type="hidden" name="gretings" value="<?php echo get_theme_mod('waorder_greeting_message','Haloo Admin'); ?>">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('waordernonce'); ?>"/>
            <input type="hidden" name="order_key" value="<?php echo waorder_order_key_generator(); ?>"/>
        </form>
    </div>
</div>
