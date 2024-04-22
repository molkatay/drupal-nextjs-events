import Link from "next/link"

import { PreviewAlert } from "components/preview-alert"
import { MenuMain } from 'components/menu--main';
import { MenuFooter } from 'components/menu--footer';
import {DrupalMenuLinkContent} from "next-drupal";
import Head from "next/head";
export interface LayoutProps {
    title?: string;
    children?: React.ReactNode;
    menus: {
        main: DrupalMenuLinkContent[];
        footer: DrupalMenuLinkContent[];
    };
}
export function Layout({ title, children, menus }):LayoutProps {
  // @ts-ignore
    return (
    <>
        <Head>
            <title>{`${title}`}</title>
        </Head>
      <PreviewAlert />
        <div className="max-w-screen-md px-6 mx-auto">
            <header className="border-b">
                <div
                    className="container flex flex-col items-center justify-between px-6 py-4 mx-auto md:flex-row">
                    <Link
                        href="/"
                        className="flex items-center mb-4 space-x-2 no-underline md:mb-0"
                    >
                        <div className="w-8 h-10">

                        </div>
                        <span
                            className="text-lg font-semibold">Acquia CMS</span>
                    </Link>
                    {menus?.main && <MenuMain menu={menus.main}/>}
                </div>
            </header>
            <main className="container py-10 mx-auto">{children}</main>
            <footer className="container px-6 mx-auto">
                <div className="pt-8 pb-12 border-t md:pt-12">
                    {menus?.footer && <MenuFooter menu={menus.footer}/>}
                </div>
            </footer>
        </div>
    </>
  )
}
