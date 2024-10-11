import { Link } from "@inertiajs/react";
import { Anchor, Breadcrumbs } from "@mantine/core";
import { IconChevronRight } from "@tabler/icons-react";
import { ItemAncestorsResourceData } from "@/Modules/Item/Types/ItemAncestorsResourceData";

interface BreadcrumbProps {
    ancestors: ItemAncestorsResourceData[];
}

export default function ItemBreadcrumbs({ ancestors }: BreadcrumbProps) {
    const breadcrumbItems = ancestors
        .map((ans) => (
            <Anchor component={Link} href={ans.url} key={ans.url}>
                {ans.name}
            </Anchor>
        ));

    return (
        <Breadcrumbs separator={<IconChevronRight size={16} />}>
            {breadcrumbItems}
        </Breadcrumbs>
    );
}