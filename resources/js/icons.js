import { library, dom } from '@fortawesome/fontawesome-svg-core';
import '@fortawesome/fontawesome-svg-core/styles.css';

// Solid icons
import {
    faCheck,
    faClock,
    faComment,
    faEnvelope,
    faExclamationCircle,
    faEye,
    faGlobe,
    faHeart,
    faImage,         // FA4: fa-photo
    faInfo,
    faKey,
    faLock,
    faMobileAlt,     // FA4: fa-mobile
    faPen,
    faPlusSquare,
    faPrint,
    faSearch,
    faShare,
    faSignOutAlt,    // FA4: fa-sign-out
    faSpoon,
    faSquare,
    faUser,
    faUtensils,      // FA4: fa-cutlery
} from '@fortawesome/free-solid-svg-icons';

// Regular icons (outlined variants)
import {
    faCheckCircle as farCheckCircle,   // FA4: fa-check-circle-o
    faClock as farClock,               // FA4: fa-clock-o
    faEnvelope as farEnvelope,         // FA4: fa-envelope-o
    faHeart as farHeart,               // FA4: fa-heart-o
} from '@fortawesome/free-regular-svg-icons';

// Brand icons
import {
    faFacebook,
    faFacebookF,
    faInstagram,
    faLinkedin,
    faPinterest,
    faPinterestP,
    faTwitter,
    faWhatsapp,
} from '@fortawesome/free-brands-svg-icons';

// Add all icons to the library
library.add(
    // Solid
    faCheck,
    faClock,
    faComment,
    faEnvelope,
    faExclamationCircle,
    faEye,
    faGlobe,
    faHeart,
    faImage,
    faInfo,
    faKey,
    faLock,
    faMobileAlt,
    faPen,
    faPlusSquare,
    faPrint,
    faSearch,
    faShare,
    faSignOutAlt,
    faSpoon,
    faSquare,
    faUser,
    faUtensils,
    // Regular
    farCheckCircle,
    farClock,
    farEnvelope,
    farHeart,
    // Brands
    faFacebook,
    faFacebookF,
    faInstagram,
    faLinkedin,
    faPinterest,
    faPinterestP,
    faTwitter,
    faWhatsapp,
);

// Replace <i> tags with <svg> elements
dom.watch();
