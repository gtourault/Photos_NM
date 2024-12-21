            <?php





            $response = '';
            $photo = get_field('photo');
            $photo_url = esc_url($photo['url']);
            $photo_title = esc_html(get_the_title());
            $photo_link = esc_url(get_permalink());
            $terms = get_the_terms(get_the_ID(), 'categorie');
            $reference = get_field('reference', get_the_ID());

            $response .= "<div class='div_container_photo gallery'>";
            //$response .= '<a href="#" class="photo_hover">';
            $response .= '<img class="gallery-image" data-reference="' . $reference . '" data-categorie="' . $terms[0]->name . '" src="' . $photo_url . '" alt="' . $photo_title . '" data-id="' . get_the_ID() . '">';
            //$response .= '<img class="gallery-image" src="' . $photo_url . '" alt="' . $photo_title . '">';
            $response .= '<div class="photo_span_container">';
            $response .= '<span class="span_link icon_fullscreen" data-src="' . $photo_url . '">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 40 40">
            <circle cx="20" cy="20" r="18" fill="black" />
            <text x="20" y="29" font-size="26" text-anchor="middle" fill="white" style="font-family: Arial, sans-serif;">⛶</text>
            </svg></span>';
            $response .= '<span class="icon_eye" data-url="' . $photo_link . '"></span>';
            $response .= '<span class="photo_category">' . $terms[0]->name . '</span>';
            $response .= '<span class="photo_title">' . $photo_title . '</span>';

            $response .= '</div>';
            $response .= '<div class="overlay">';
            $response .= '</div>';
            //$response .= "</a>";
            $response .= "</div>";
            echo $response;
            ?>

