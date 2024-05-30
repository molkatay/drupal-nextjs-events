import { DrupalMenuLinkContent } from 'next-drupal';
import { drupal } from '../lib/drupal';
import { GetStaticPropsContext } from 'next';

export async function getMenus(context?: GetStaticPropsContext): Promise<{
    main: DrupalMenuLinkContent[];
    footer: DrupalMenuLinkContent[];
}> {
    let options: { defaultLocale: any; locale: any } = {};
    if (context) {
        options = { defaultLocale: context.defaultLocale, locale: context.locale };
    }

    const { tree: mainMenu } = await drupal.getMenu('main', options);
    const { tree: footerMenu } = await drupal.getMenu('footer', options);
    return {
        main: mainMenu,
        footer: footerMenu,
    };
}
