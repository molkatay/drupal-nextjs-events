import { GetStaticPropsContext } from 'next';

interface SiteInfos {
    name: string;
    slogan: string;
    logo: string;
    favicon: string;
}

export async function getSiteInfos(context?: GetStaticPropsContext): Promise<SiteInfos> {
    try {
        // Fetch site configuration
        const response = await fetch(`${process.env.NEXT_PUBLIC_DRUPAL_BASE_URL}/jsonapi/site-config`, {
            cache: "no-cache",
        });
        if (!response.ok) {
            throw new Error(`Failed to fetch site configuration: ${response.statusText}`);
        }
        const data = await response.json();
        // Assuming the structure of your API response
        const siteInfos = {
            name: data.data.attributes.name || "default name",
            slogan: data.data.attributes.slogan || "default slogan",
            logo: data.data.attributes.global_logo || "/hilink-logo.svg",
            favicon: data.data.attributes.global_favicon || "default favicon URL",
        };
        return siteInfos;

    } catch (error) {
        console.error("Error fetching site configuration:", error);
        return {
            name: "default name",
            slogan: "default slogan",
            logo: "/hilink-logo.svg",
            favicon: "default logo url"
        };
    }
}
