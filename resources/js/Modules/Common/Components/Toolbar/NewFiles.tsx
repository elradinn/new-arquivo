import { PageProps } from "@/types";
import { useForm, usePage } from "@inertiajs/react";
import { Button, Flex, Menu, Modal, rem, Stack, Text, TextInput } from "@mantine/core";
import { useDisclosure } from "@mantine/hooks";
import { notifications } from "@mantine/notifications";
import {
    IconChevronDown,
    IconFileIsr,
    IconFolderPlus,
    IconFolderUp,
    IconPlus,
} from "@tabler/icons-react";
import React, { FormEventHandler } from "react";

interface IFormProps {
    isOpened: boolean;
    close: () => void;
}

interface FormData {
    name: string;
    parent_id?: number;
}

const CreateFolderForm: React.FC<IFormProps> = ({ isOpened, close }) => {
    const { data, setData, post, processing, errors, reset } = useForm<FormData>({
        name: "",
        parent_id: 0,
    });

    const parent_id = usePage<PageProps>().props.folder?.id;

    const createFolderSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        data.parent_id = parent_id;

        post(route("folder.create"), {
            preserveScroll: true,
            onSuccess: () => {
                close();
                notifications.show({
                    message: "New folder created",
                    color: "green",
                });
            },
            onError: () => {
                close();
                notifications.show({
                    message: "Something went wrong",
                    color: "red",
                });
            },
            onFinish: () => reset(),
        });
    };

    return (
        <Modal
            opened={isOpened}
            onClose={close}
            title={
                <Text fw="bold" size="lg">
                    Create Folder
                </Text>
            }
            size={550}
        >
            <form onSubmit={createFolderSubmit}>
                <Stack gap={16}>
                    <TextInput
                        id="name"
                        type="text"
                        name="name"
                        value={data.name}
                        placeholder="Folder Name"
                        onChange={(e) => setData("name", e.target.value)}
                        error={errors.name}
                    />
                </Stack>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="outline" onClick={close}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit" loading={processing}>
                        Create
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

interface IButtonProps {
    uploadFileRef?: React.RefObject<() => void>;
}

const NewFilesButton: React.FC<IButtonProps> = ({ uploadFileRef }) => {
    const [createFolderOpened, { open: openCreateFolder, close: closeCreateFolder }] =
        useDisclosure(false);

    return (
        <>
            <Menu
                shadow="md"
                width={220}
                transitionProps={{
                    transition: "pop-top-left",
                }}
                position="bottom-start"
            >
                <Menu.Target>
                    <Button
                        variant="subtle"
                        color="dark.3"
                        leftSection={<IconPlus size={18} />}
                        rightSection={<IconChevronDown size={12} />}
                    >
                        New
                    </Button>
                </Menu.Target>

                <Menu.Dropdown>
                    <Menu.Item
                        leftSection={
                            <IconFolderPlus
                                style={{
                                    width: rem(14),
                                    height: rem(14),
                                }}
                            />
                        }
                        onClick={openCreateFolder}
                    >
                        New Folder
                    </Menu.Item>
                    <Menu.Item
                        leftSection={
                            <IconFileIsr
                                style={{
                                    width: rem(14),
                                    height: rem(14),
                                }}
                            />
                        }
                        onClick={() => uploadFileRef?.current?.()}
                    >
                        Upload Files
                    </Menu.Item>
                    <Menu.Item
                        leftSection={
                            <IconFolderUp
                                style={{
                                    width: rem(14),
                                    height: rem(14),
                                }}
                            />
                        }
                    >
                        Upload Folder
                    </Menu.Item>
                </Menu.Dropdown>
            </Menu>

            <CreateFolderForm isOpened={createFolderOpened} close={closeCreateFolder} />
        </>
    );
};

export default NewFilesButton;
