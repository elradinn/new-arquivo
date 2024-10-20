import { Head } from "@inertiajs/react";
import {
    ActionIcon,
    Button,
    Flex,
    Group,
    Stack,
    Text,
    Textarea,
    TextInput,
} from "@mantine/core";
import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import {
    IconEdit,
    IconFile,
    IconFolder,
    IconPlus,
    IconTrash,
} from "@tabler/icons-react";
import Toolbar from "@/Modules/Common/Components/Toolbar/Toolbar";
import { FolderResourceData } from "@/Modules/Folder/Types/FolderResourceData";
import { ItemAncestorsResourceData } from "@/Modules/Item/Types/ItemAncestorsResourceData";
import ItemBreadcrumbs from "@/Modules/Item/Components/ItemBreadcrumbs";

interface IProps {
    folder: FolderResourceData;
    itemAncestors: ItemAncestorsResourceData[];
}

export default function FolderPropertiesPage({ folder, itemAncestors }: IProps) {
    return (
        <Authenticated toolbar={<Toolbar page="folder" />}>
            <Head title={folder.name} />
            <Stack px={8} py={8} gap={24} w={550} mb={72}>
                <ItemBreadcrumbs ancestors={itemAncestors} />

                <Group mt={24}>
                    <IconFolder size={56} fill="orange" stroke="none" color="none" />
                    <Text fw={500}>{folder.name}</Text>
                    <ActionIcon variant="subtle" color="gray">
                        <IconEdit size={24} />
                    </ActionIcon>
                </Group>

                <Textarea label="Notes" autosize minRows={4} maxRows={6} defaultValue={"This is a note, todo make field for notes"} />

                {/* <Stack gap={12}>
                    <Text size="sm" fw={500}>
                        Custom Metadata Field
                    </Text>

                    <Group justify="space-between">
                        <TextInput
                            id="name"
                            type="text"
                            name="document_number"
                            value="Country"
                            readOnly
                        />

                        <TextInput
                            id="name"
                            type="text"
                            name="document_number"
                            defaultValue="Belgium"
                        />

                        <ActionIcon color="gray" variant="subtle">
                            <IconTrash size="1rem" />
                        </ActionIcon>
                    </Group>

                    <Group justify="space-between">
                        <TextInput
                            id="name"
                            type="text"
                            name="document_number"
                            value="Application Type"
                            readOnly
                        />

                        <TextInput
                            id="name"
                            type="text"
                            name="document_number"
                            defaultValue="Outbound"
                        />

                        <ActionIcon color="gray" variant="subtle">
                            <IconTrash size="1rem" />
                        </ActionIcon>
                    </Group>

                    <Flex justify="flex-start">
                        <Button
                            variant="subtle"
                            color="blue.5"
                            leftSection={<IconPlus size={18} />}
                        >
                            Add Metadata
                        </Button>
                    </Flex>
                </Stack> */}

                {/* <Stack gap={12}>
                    <Text size="sm" fw={500}>
                        Related Files
                    </Text>

                    <Group justify="space-between">
                        <Group>
                            <IconFolder size={28} fill="orange" stroke={1.5} color="orange" />
                            <Text size="sm" fw={400}>
                                Projects
                            </Text>
                        </Group>

                        <ActionIcon color="gray" variant="subtle">
                            <IconTrash size="1rem" />
                        </ActionIcon>
                    </Group>

                    <Group justify="space-between">
                        <Group>
                            <IconFile size={28} stroke={1.5} color="gray" />
                            <Text size="sm" fw={400}>
                                Sample Document.pdf
                            </Text>
                        </Group>

                        <ActionIcon color="gray" variant="subtle">
                            <IconTrash size="1rem" />
                        </ActionIcon>
                    </Group>

                    <Flex justify="flex-start">
                        <Button
                            variant="subtle"
                            color="blue.5"
                            leftSection={<IconPlus size={18} />}
                        >
                            Add Related File
                        </Button>
                    </Flex>
                </Stack> */}

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="outline" onClick={close}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit">
                        Save
                    </Button>
                </Flex>
            </Stack>
        </Authenticated>
    );
}
