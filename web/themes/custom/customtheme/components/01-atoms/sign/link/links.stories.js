import link from './link.twig';

import linkData from './link.yml';

/**
 * Storybook Definition.
 */
export default { title: 'Atoms/sign' };

export const sign = () => link(linkData);
