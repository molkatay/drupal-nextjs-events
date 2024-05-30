import {useRouter} from 'next/router';
import Link from 'next/link';
import classNames from 'classnames';
import {DrupalMenuLinkContent} from 'next-drupal';

interface MenuFooterProps {
    menu?: DrupalMenuLinkContent[];
}

export function MenuFooter({menu, ...props}: MenuFooterProps) {
    const router = useRouter();
    if (!menu?.length) {
        return null;
    }

    return (
        <nav data-cy="footer-menu" {...props}>
            <ul className="flex justify-center space-x-4 text-sm">
                {menu?.map((item) => {
                    const isActive =
                        router.asPath === item.url ||
                        (item.url !== '/' ? router.asPath.indexOf(item.url) === 0 : false);

                    return (
                        <li
                            key={item.id}
                            className={classNames('menu-item regular-16 text-gray-50 flexCenter cursor-pointer pb-1.5 transition-all hover:font-bold', {
                                'menu-item--active-trail': isActive,
                            })}
                        >
                            <Link
                                href={item.url}
                                className={classNames(
                                    isActive ? 'text-black' : 'text-gray-30',
                                )}
                            >
                                {item.title}
                            </Link>
                        </li>
                    );
                })}
            </ul>
        </nav>
    );
}
