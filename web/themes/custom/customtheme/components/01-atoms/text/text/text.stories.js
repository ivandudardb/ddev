import heading from '../headings/_heading.twig';
import date from '../../logo_and_date/logo_and_date.twig';
import pre from './05-search.twig';
import paragraph from './03-weather.twig';
import code from './07-code.twig';

import dateData from './blockquote.yml';
import headingData from '../headings/headings.yml';
import codeData from './code.yml';

/**
 * Storybook Definition.
 */
export default { title: 'Atoms/Text' };

// Loop over items in headingData to show each one in the example below.
const headings = headingData.map((d) => heading(d)).join('');

export const headingsExamples = () => headings;

export const dateExample = () => date(dateData);

export const preformatted = () => pre();

export const weather = () => paragraph();

export const codeExample = () => code(codeData);
